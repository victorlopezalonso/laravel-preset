<?php

namespace Tests;

use App\Models\Copy;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @internal
 * @coversNothing
 */
final class ApiTestCase extends TestCase
{
    use DatabaseTransactions;

    //Terminal colors
    const CLEAR = "\e[0m";
    const WARNING = "\e[41;97m";
    const CAUTION = "\e[43;30m";
    const OK = "\e[42;30m";

    protected $preserveGlobalState = false;
    protected $runTestInSeparateProcess = true;

    protected $headers = [];
    protected $params = [];
    protected $data = [];
    protected $emails = [];

    /** @var TestResponse */
    protected $testResponse;

    /** @var mixed */
    protected $response;

    /** @var User */
    protected $user;

    /**
     * Init config.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->initHeaders();
        Mail::getSwiftMailer()->registerPlugin(new TestingMailEventListener($this));
    }

    /**
     * Empty the api call headers.
     */
    public function emptyHeaders()
    {
        $this->headers = [];
        $this->setHeader('Accept', 'application/json');
    }

    /**
     * Default api call headers.
     */
    public function initHeaders()
    {
        $this->emptyHeaders();
        $this->setHeader('Accept', 'application/json');
        $this->setHeader(API_KEY_HEADER, env('APP_KEY'));
        $this->setHeader(OS_HEADER, 'Android');
        $this->setHeader(APP_VERSION_HEADER, '1.0.0');
    }

    /**
     * Add/update an api call header.
     *
     * @param $header
     * @param $value
     */
    public function setHeader($header, $value)
    {
        $this->headers['HTTP_'.$header] = $value;
    }

    /**
     * Add/update an api call param.
     *
     * @param $key
     * @param $value
     *
     * @return ApiTestCase
     */
    public function setParam($key, $value)
    {
        $this->params[$key] = $value;

        return $this;
    }

    /**
     * Set an auth user.
     *
     * @param null $user
     *
     * @return mixed|User
     */
    public function signIn($user = null)
    {
        $this->user = $user ?: factory(User::class)->create();
        $this->actingAs($this->user, 'api');

        return $this->user;
    }

    /**
     * Auth user.
     *
     * @return User
     */
    public function auth()
    {
        return $this->user;
    }

    /**
     * Original response content.
     *
     * @return TestResponse
     */
    public function response()
    {
        return $this->testResponse;
    }

    /**
     * @param array $attributes
     * @param $object
     */
    public function assertObjectHasAttributes(array $attributes, $object)
    {
        foreach ($attributes as $attribute) {
            $this->assertObjectHasAttribute($attribute, $object);
        }
    }

    /**
     * Check if the object.
     *
     * @param array $attributes
     */
    public function assertDataHasAttributes(array $attributes)
    {
        if (\is_array($this->response['data'])) {
            foreach ($this->response['data'] as $object) {
                $this->assertObjectHasAttributes($attributes, $object);
            }

            return;
        }

        $this->assertObjectHasAttributes($attributes, $this->response['data']);
    }

    /**
     * Comprueba que el campo data de la respuesta devuelva un null.
     */
    public function assertResponseDataIsNull()
    {
        $this->assertNull($this->response['data']);

        return $this;
    }

    /**
     * Comprueba que el campo data de la respuesta devuelva un null.
     */
    public function assertResponseDataIsNotNull()
    {
        $this->assertNotNull($this->response['data']);

        return $this;
    }

    /**
     * Comprueba que el campo data de la respuesta devuelva un null.
     */
    public function assertResponseDataIsAnArray()
    {
        $this->assertInternalType('array', $this->response['data']);

        return $this;
    }

    /**
     * @param $key
     *
     * @return ApiTestCase
     */
    public function assertMessage($key)
    {
        $this->assertSame(Copy::server($key), $this->response['message'] ?? null);

        return $this;
    }

    /**
     * @return $this
     */
    public function assertEmailWasSent()
    {
        $this->assertNotEmpty($this->emails, 'Faled asserting that an email was sent');

        return $this;
    }

    /**
     * @param $count
     *
     * @return $this
     */
    public function assertEmailsWereSent($count)
    {
        $this->assertCount($count, $this->emails, "Faled asserting that ${count} email(s) was sent");

        return $this;
    }

    /**
     * @param $recipient
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function assertSeeMailTo($recipient)
    {
        if (! $email = end($this->emails)) {
            throw new \Exception("No email was sent to ${recipient}");
        }

        $this->assertArrayHasKey($recipient, $email->getTo(), "No email was sent to ${recipient}");

        return $this;
    }

    /**
     * Añade un archivo a la llamada.
     *
     * @param $path
     */
    public function attachFile($path)
    {
        $fileName = basename($path);
        $fileNameWithoutExtension = pathinfo($path, PATHINFO_FILENAME);
        $this->params[$fileNameWithoutExtension] = new UploadedFile($path, $fileName, null, null, null, true);
    }

    /**
     * Realiza una llamada a un servicio del api.
     *
     * @param string $method
     * @param string $uri
     *
     * @return TestResponse
     */
    public function apiCall(string $method, string $uri)
    {
        $this->testResponse = $this->json($method, $uri, $this->params, $this->headers);

        $this->response = $this->testResponse->getOriginalContent();
        $this->data = $this->response['data'] ?? null;

        return $this->testResponse;
    }

    /**
     * Muestra los logs en los test.
     */
    public function showResponse()
    {
        $this->info('HEADERS: '.json_encode($this->headers));
        $this->info('PARAMS: '.json_encode($this->params));
        $this->caution('RESPONSE: '.json_encode($this->response));
    }

    /**
     * Muestra un mensaje de color en la consola.
     *
     * @param string $color
     * @param $text
     */
    public function consoleLog(string $color, $text)
    {
        echo PHP_EOL.$color.$text.self::CLEAR.PHP_EOL;
    }

    /**
     * Mensaje de color rojo.
     *
     * @param $text
     */
    public function warning($text)
    {
        $this->consoleLog(self::WARNING, $text);
    }

    /**
     * Mensaje de color naranja.
     *
     * @param $text
     */
    public function caution($text)
    {
        $this->consoleLog(self::CAUTION, $text);
    }

    /**
     * Mensaje de color verde.
     *
     * @param $text
     */
    public function ok($text)
    {
        $this->consoleLog(self::OK, $text);
    }

    /**
     * Mensaje sin color.
     *
     * @param $text
     */
    public function info($text)
    {
        $this->consoleLog(self::CLEAR, $text);
    }

    public function addEmail(\Swift_Message $email)
    {
        $this->emails[] = $email;
    }
}

class TestingMailEventListener implements \Swift_Events_EventListener
{
    /** @var ApiTestCase */
    protected $test;

    /**
     * @param $test
     */
    public function __construct($test)
    {
        $this->test = $test;
    }

    /**
     * @param $event
     */
    public function beforeSendPerformed($event)
    {
        $this->test->addEmail($event->getMessage());
        //$message = $event->getMessage();

        //dd($message->getTo());
        //dd($message->getFrom());
        //dd($message->getBody());
    }
}
