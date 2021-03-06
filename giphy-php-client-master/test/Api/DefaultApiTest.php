<?php
/**
 * DefaultApiTest
 * PHP version 5
 *
 * @category Class
 * @package  GPH
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * giphy-api
 *
 * Giphy's public api.
 *
 * OpenAPI spec version: 0.9.3
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Please update the test case below to test the endpoint.
 */

namespace GPH;

use \GPH\Configuration;
use \GPH\ApiClient;
use \GPH\ApiException;
use \GPH\ObjectSerializer;

/**
 * DefaultApiTest Class Doc Comment
 *
 * @category Class
 * @package  GPH
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class DefaultApiTest extends \PHPUnit_Framework_TestCase
{

    private $api_instance;

    /**
     * Setup before running any test cases
     */
    public static function setUpBeforeClass()
    {
    }

    /**
     * Setup before running each test case
     */
    public function setUp()
    {
        $this->api_instance = new Api\DefaultApi();
    }

    /**
     * Clean up after running each test case
     */
    public function tearDown()
    {
    }

    /**
     * Clean up after running all test cases
     */
    public static function tearDownAfterClass()
    {
    }

    /**
     * Test case for gifsCategoriesCategoryGet
     *
     * Category Tags Endpoint..
     *
     */
    public function testGifsCategoriesCategoryGet()
    {
        $resp = $this->api_instance->gifsCategoriesCategoryGet("dc6zaTOxFJmzC", "actions", 10, 0);
        $this->assertEquals(count($resp["data"]), 10);
        foreach ($resp["data"] as $item) {
            $this->assertNotEmpty($item["name"]);
        }
    }

    /**
     * Test case for gifsCategoriesCategoryTagGet
     *
     * Tagged Gifs Endpoint..
     *
     */
    public function testGifsCategoriesCategoryTagGet()
    {
        $resp = $this->api_instance->gifsCategoriesCategoryTagGet("dc6zaTOxFJmzC", "actions", "breaking-up", 10, 0);
        $this->assertEquals(count($resp["data"]), 10);
        foreach ($resp["data"] as $item) {
            $this->assertNotEmpty($item["url"]);
        }
    }

    /**
     * Test case for gifsCategoriesGet
     *
     * Categories Endpoint..
     *
     */
    public function testGifsCategoriesGet()
    {
        $resp = $this->api_instance->gifsCategoriesGet("dc6zaTOxFJmzC", 10);
        $this->assertEquals(count($resp["data"]), 10);
        foreach ($resp["data"] as $item) {
            $this->assertNotEmpty($item["name"]);
        }
    }

    /**
     * Test case for gifsGet
     *
     * Get GIFs by ID Endpoint.
     *
     */
    public function testGifsGet()
    {
        $resp = $this->api_instance->gifsGet("dc6zaTOxFJmzC", "YfCuW2maPixri,BeL3iFbYzAsfu");
        $this->assertEquals(count($resp["data"]), 2);
    }

    /**
     * Test case for gifsGifIdGet
     *
     * Get GIF by ID Endpoint.
     *
     */
    public function testGifsGifIdGet()
    {
        $resp = $this->api_instance->gifsGifIdGet("dc6zaTOxFJmzC", "YfCuW2maPixri");
        $this->assertEquals($resp["data"]["id"], "YfCuW2maPixri");
    }

    /**
     * Test case for gifsRandomGet
     *
     * Random Endpoint.
     *
     */
    public function testGifsRandomGet()
    {
        $resp = $this->api_instance->gifsRandomGet("dc6zaTOxFJmzC");
        $this->assertNotEmpty($resp["data"]["url"]);
    }

    /**
     * Test case for gifsSearchGet
     *
     * Search Endpoint.
     *
     */
    public function testGifsSearchGet()
    {
        $resp = $this->api_instance->gifsSearchGet("dc6zaTOxFJmzC", "cats", 10, 0);
        $this->assertEquals(count($resp["data"]), 10);
    }

    /**
     * Test case for gifsTranslateGet
     *
     * Translate Endpoint.
     *
     */
    public function testGifsTranslateGet()
    {
        $resp = $this->api_instance->gifsTranslateGet("dc6zaTOxFJmzC", "cat");
        $this->assertNotEmpty($resp["data"]["url"]);
    }

    /**
     * Test case for gifsTrendingGet
     *
     * Trending GIFs Endpoint.
     *
     */
    public function testGifsTrendingGet()
    {
        $resp = $this->api_instance->gifsTrendingGet("dc6zaTOxFJmzC", 10);
        $this->assertEquals(count($resp["data"]), 10);
        foreach ($resp["data"] as $item) {
            $this->assertNotEmpty($item["url"]);
        }
    }

    /**
     * Test case for stickersRandomGet
     *
     * Random Sticker Endpoint.
     *
     */
    public function testStickersRandomGet()
    {
        $resp = $this->api_instance->stickersRandomGet("dc6zaTOxFJmzC");
        $this->assertNotEmpty($resp["data"]["url"]);
    }

    /**
     * Test case for stickersSearchGet
     *
     * Sticker Search Endpoint.
     *
     */
    public function testStickersSearchGet()
    {
        $resp = $this->api_instance->stickersSearchGet("dc6zaTOxFJmzC", "cats", 10);
        $this->assertEquals(count($resp["data"]), 10);
    }

    /**
     * Test case for stickersTranslateGet
     *
     * Sticker Translate Endpoint.
     *
     */
    public function testStickersTranslateGet()
    {
        $resp = $this->api_instance->stickersTranslateGet("dc6zaTOxFJmzC", "cat");
        $this->assertNotEmpty($resp["data"]["url"]);
    }

    /**
     * Test case for stickersTrendingGet
     *
     * Trending Stickers Endpoint.
     *
     */
    public function testStickersTrendingGet()
    {
        $resp = $this->api_instance->stickersTrendingGet("dc6zaTOxFJmzC", 10);
        $this->assertEquals(count($resp["data"]), 10);
        foreach ($resp["data"] as $item) {
            $this->assertNotEmpty($item["url"]);
        }
    }

}
