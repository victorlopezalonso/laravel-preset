<?php

use App\Classes\OneSignal;
use PHPUnit\Framework\TestCase;

class PushTest extends TestCase
{

    /** @test */
    public function push_make_method_must_return_an_instance_of_self()
    {
        $this->assertInstanceOf(OneSignal::class, OneSignal::make());
    }

    /** @test */
    public function push_to_json_must_return_an_object_containing_the_params()
    {
        $title   = ['es' => 'título', 'en' => 'title'];
        $content = ['es' => 'contenido', 'en' => 'body'];
        $pushId  = ['pushId1', 'pushId2'];
        $tags    = ['TAG1', 'TAG2'];
        $eventId = 1;
        $data    = ['test' => true];

        $response = OneSignal::make()
                             ->title($title)
                             ->content($content)
                             ->wherePushIdIn($pushId)
                             ->whereTagEquals('TAG_KEY', 'TAG_VALUE')
                             ->whereTagIn($tags)
                             ->eventId($eventId)
                             ->data($data)
                             ->toJson();

        $this->assertEquals($title, $response->params['headings']);
        $this->assertEquals($content, $response->params['contents']);

        $this->assertContains($pushId[0], $response->params['include_player_ids']);
        $this->assertContains($pushId[1], $response->params['include_player_ids']);

        $this->assertCount(5, $response->params['filters']);
        $this->assertcontains('TAG_KEY', $response->params['filters'][0]);
        $this->assertcontains('TAG_VALUE', $response->params['filters'][0]);
        $this->assertcontains($tags[0], $response->params['filters'][2]);
        $this->assertcontains($tags[1], $response->params['filters'][4]);

        $this->assertEquals($eventId, $response->params['data']['eventId']);
        $this->assertEquals($data, $response->params['data']['data']);
    }

}