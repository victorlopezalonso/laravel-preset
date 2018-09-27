<?php

/**
 * ************************************************************
 * SWAGGER API INFO
 * ************************************************************
 * @SWG\Swagger(
 *   @SWG\Info(
 *     title=API_DOCS_TITLE,
 *     version="1.0.0",
 *     description=""
 *   )
 * )
 * ************************************************************
 * HEADER PARAMS
 * ************************************************************
 * @SWG\Parameter(name="Accept", in="header", required=true, type="string", description="Response type", default="application/json")
 * @SWG\Parameter(name="Authorization", in="header", required=true, type="string", description="User access token prefixed with 'Bearer '", default="")
 * @SWG\Parameter(name="refreshToken", in="header", required=true, type="string", description="User refresh token", default="")
 * @SWG\Parameter(name=API_KEY_HEADER, in="header", required=true, type="string", description="Base64 key to access to the API", default=API_KEY)
 * @SWG\Parameter(name=OS_HEADER, in="header", required=true, type="string", description="Operating System: Android|iOS", default="Android")
 * @SWG\Parameter(name=LANGUAGE_HEADER, in="header", type="string", description="Language code to get the response", default="en")
 * @SWG\Parameter(name=APP_VERSION_HEADER, in="header", required=true, type="string", description="Device app version in string format", default="0.0.1")
 * ************************************************************
 * ACCESS TOKEN
 * ************************************************************
 * @SWG\Definition(
 *   definition="AccessToken",
 *   @SWG\Property(property="accessToken", type="string", description="Bearer access token", example="eyA4G3H4......"),
 *   @SWG\Property(property="refreshToken", type="string", description="Refresh token (*only when the token expires)", example="eyASD8FJ......"),
 *   @SWG\Property(property="expires", type="integer", description="Expiration time in seconds (*only when the token expires)", example="86.400")
 * )
 * ************************************************************
 * RESPONSE OBJECT
 * ************************************************************
 * @SWG\Definition(
 *   definition="Response",
 *	 @SWG\Property(property="message", type="string", description="Client Message", example="OK"),
 *	 @SWG\Property(property="data", type="object", description="Data Response (Mixed type)"),
 *	 @SWG\Property(property="error", type="object", description="Error object",
 *   	@SWG\Property(property="code", type="integer", description="Error Code", example=0),
 *   	@SWG\Property(property="message", type="string", description="Debug Message", example=""),
 *   ),
 *   @SWG\Property(property="validations", type="object", description="Not passed validations as key/value -> ex: {'name':'name is required'}"),
 *	 @SWG\Property(property="paginator", type="object", description="Pagination object",
 *   	@SWG\Property(property="prev", type="integer", description="Previous page number", example="1"),
 *   	@SWG\Property(property="current", type="integer", description="Current page number", example="2"),
 *   	@SWG\Property(property="next", type="integer", description="Next page number", example="3"),
 *   	@SWG\Property(property="total", type="integer", description="Total number of pages", example="4"),
 *   	@SWG\Property(property="limit", type="integer", description="Limit per page", example="64 -> the client can pass the parameter 'limit' to the server to change the number of results per page"),
 *   ),
 *  )
 */