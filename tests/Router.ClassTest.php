<?php
/**
 * User: Mark Adkins
 * Date: 2/10/2019
 * Time: 12:46 PM
 */

use PHPUnit\Framework\TestCase;

/**
 *  Corresponding Class to test YourClass class
 *
 *  For each class in your library, there should be a corresponding Unit-Test for it
 *  Unit-Tests should be as much as possible independent from other test going on.
 *
 *  @author Mark Adkins <mark@kuipr.com>
 */
class RouterTest extends TestCase
{

    public function setUp() {
        // OVERRIDE SERVER VARIABLES FOR TESTS
        $_SERVER['REQUEST_URI'] = "/";
        $_SERVER['REQUEST_METHOD'] = "GET";
    }

    /**
     * Verify that the Router Class has no syntax errors.
     */
    public function testSyntaxErrors() {
        $var = new FunkyBunch\SimpleHTTPRouter\Router;
        $this->assertTrue(is_object($var));
        unset($var);
    }

    /**
     * Verify that the get() method has no syntax errors.
     *
     * This test also evaluates proper routing for 'GET' requests.  The simulated request is set
     * to `/test-a` so the get() request for the path `/test-a` should be the only one to
     * return results.
     */
    public function testAllowedGetPaths() {
        $_SERVER['REQUEST_URI'] = "/get-test-a";

        echo "{{POST}} REQUEST_URI set to ".$_SERVER['REQUEST_URI'].PHP_EOL;
        echo "{{POST}} REQUEST_METHOD set to ".$_SERVER['REQUEST_METHOD'].PHP_EOL.".".PHP_EOL;
        echo "Expecting:".PHP_EOL.
            " ~ test-a == true".PHP_EOL.
            " ~ test-b == false".PHP_EOL.
            " ~ test-c == false".PHP_EOL;

        $var = new FunkyBunch\SimpleHTTPRouter\Router;
        $this->assertTrue($var->get("/get-test-a", function(){echo "Result: test-a".PHP_EOL;}));
        $this->assertFalse($var->get("/get-test-b", function(){echo "Result: test-b".PHP_EOL;}));
        $this->assertFalse($var->get("/get-test-c", function(){echo "Result: test-c".PHP_EOL;}));
        echo PHP_EOL.PHP_EOL;
        unset($var);
    }

    /**
     * Verify that the post() method has no syntax errors.
     *
     * This test also evaluates proper routing for 'POST' requests.  The simulated request is set
     * to `/test-a` so the post() request for the path `/test-a` should be the only one to
     * return results.
     */
    public function testAllowedPostPaths() {
        $_SERVER['REQUEST_URI'] = "/post-test-d";
        $_SERVER['REQUEST_METHOD'] = "POST";

        echo "{{POST}} REQUEST_URI set to ".$_SERVER['REQUEST_URI'].PHP_EOL;
        echo "{{POST}} REQUEST_METHOD set to ".$_SERVER['REQUEST_METHOD'].PHP_EOL.".".PHP_EOL;
        echo "Expecting:".PHP_EOL.
            " ~ test-d == true".PHP_EOL.
            " ~ test-e == false".PHP_EOL.
            " ~ test-f == false".PHP_EOL;

        $var = new FunkyBunch\SimpleHTTPRouter\Router;
        $this->assertTrue($var->post("/post-test-d", function(){echo "Result: test-d".PHP_EOL;}));
        $this->assertFalse($var->post("/post-test-e", function(){echo "Result: test-e".PHP_EOL;}));
        $this->assertFalse($var->post("/post-test-f", function(){echo "Result: test-f".PHP_EOL;}));
        echo PHP_EOL.PHP_EOL;
        unset($var);
    }

    /**
     * Verify that post() does not respond to get() for the same REQUEST_URI.
     */
    public function testGetToPostResponse() {
        $_SERVER['REQUEST_URI'] = "/test-g";
        $_SERVER['REQUEST_METHOD'] = "GET";

        echo "{{POST}} REQUEST_URI set to ".$_SERVER['REQUEST_URI'].PHP_EOL;
        echo "{{POST}} REQUEST_METHOD set to ".$_SERVER['REQUEST_METHOD'].PHP_EOL.".".PHP_EOL;
        echo "Expecting:".PHP_EOL.
            " ~ GET  == true".PHP_EOL.
            " ~ POST == false".PHP_EOL;

        $var = new FunkyBunch\SimpleHTTPRouter\Router;
        $this->assertTrue($var->get("/test-g", function(){echo "Result: GET".PHP_EOL;}));
        $this->assertFalse($var->post("/test-g", function(){echo "Result: POST".PHP_EOL;}));
        echo PHP_EOL.PHP_EOL;
        unset($var);
    }

    /**
     * Verify that get() does not respond to post() for the same REQUEST_URI.
     */
    public function testPostToGetResponse() {
        $_SERVER['REQUEST_URI'] = "/test-g";
        $_SERVER['REQUEST_METHOD'] = "POST";

        echo "{{POST}} REQUEST_URI set to ".$_SERVER['REQUEST_URI'].PHP_EOL;
        echo "{{POST}} REQUEST_METHOD set to ".$_SERVER['REQUEST_METHOD'].PHP_EOL.".".PHP_EOL;
        echo "Expecting:".PHP_EOL.
            " ~ GET  == false".PHP_EOL.
            " ~ POST == true".PHP_EOL;

        $var = new FunkyBunch\SimpleHTTPRouter\Router;
        $this->assertFalse($var->get("/test-g", function(){echo "Result: GET".PHP_EOL;}));
        $this->assertTrue($var->post("/test-g", function(){echo "Result: POST".PHP_EOL;}));
        echo PHP_EOL.PHP_EOL;
        unset($var);
    }
}