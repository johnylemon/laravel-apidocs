<?php

namespace Johnylemon\Apidocs\Tests;

use Johnylemon\Apidocs\Facades\Apidocs;
use Johnylemon\Apidocs\Facades\Param;
use Johnylemon\Apidocs\Endpoints\Endpoint;
use Johnylemon\Apidocs\Tests\Data\TestEndpoint;
use Johnylemon\Apidocs\Exceptions\InvalidEndpoint;
use Johnylemon\Apidocs\Exceptions\GroupNotFound;

class ApidocsTest extends TestCase
{
    /** @test */
    public function default_group_exists()
    {
        $this->assertTrue(Apidocs::groupDefined('non-groupped'));
        $this->assertCount(1, Apidocs::groups());
    }

    /** @test */
    public function can_register_apidocs_group()
    {
        Apidocs::defineGroup('slug', 'Title', 'Description');
        $this->assertCount(2, Apidocs::groups());

        Apidocs::defineGroup('slug', 'Modified title', 'Description');
        $this->assertCount(2, Apidocs::groups());

        Apidocs::defineGroup('other', 'Other');
        $this->assertCount(3, Apidocs::groups());
    }

    /** @test */
    public function can_register_endpoint()
    {
        $endpoint = Apidocs::register(NULL);
        $this->assertTrue($endpoint instanceof Endpoint);
        $this->assertCount(1, Apidocs::getRoutes());

        $endpoint = Apidocs::register(TestEndpoint::class);
        $this->assertTrue($endpoint instanceof Endpoint);
        $this->assertCount(2, Apidocs::getRoutes());

        $endpoint = Apidocs::register(new TestEndpoint);
        $this->assertTrue($endpoint instanceof Endpoint);
        $this->assertCount(3, Apidocs::getRoutes());
    }

    /** @test */
    public function throws_exception_on_integer()
    {
        $this->expectException(InvalidEndpoint::class);
        Apidocs::register(7);
    }

    /** @test */
    public function throws_exception_on_string()
    {
        $this->expectException(InvalidEndpoint::class);
        Apidocs::register('a');
    }

    /** @test */
    public function throws_exception_on_invalid_class()
    {
        $this->expectException(InvalidEndpoint::class);
        Apidocs::register(NonExistent::class);
    }

    /** @test */
    public function throws_exception_on_array()
    {
        $this->expectException(InvalidEndpoint::class);
        Apidocs::register([1,2,3]);
    }

    /** @test */
    public function throws_exception_on_bool()
    {
        $this->expectException(InvalidEndpoint::class);
        Apidocs::register(TRUE);
    }

    /** @test */
    public function throws_exception_on_object()
    {
        $this->expectException(InvalidEndpoint::class);
        Apidocs::register((object)["a" => "b"]);
    }

    /** @test */
    public function can_register_endpoint_title()
    {
        $endpoint = Apidocs::register(TestEndpoint::class)->title("aaa");

        $this->assertMethod($endpoint, 'title', 'aaa');
    }

    /** @test */
    public function can_register_endpoint_description()
    {
        $endpoint = Apidocs::register(TestEndpoint::class)->description("aaa");

        $this->assertMethod($endpoint, 'description', 'aaa');

        $endpoint->desc("bbb");
        $this->assertMethod($endpoint, 'description', 'bbb');
    }

    /** @test */
    public function can_register_endpoint_method()
    {
        $endpoint = Apidocs::register(TestEndpoint::class)->method("GET");

        $this->assertMethod($endpoint, 'method', 'GET');
    }

    /** @test */
    public function can_register_endpoint_group()
    {
        Apidocs::defineGroup('johnylemon', "Apidocs");
        $endpoint = Apidocs::register(TestEndpoint::class)->group("johnylemon");
        $this->assertMethod($endpoint, 'group', 'johnylemon');

        $this->expectException(GroupNotFound::class);
        $endpoint = Apidocs::register(TestEndpoint::class)->group("apidocs");
    }

    /** @test */
    public function can_register_endpoint_uri()
    {
        $endpoint = Apidocs::register(TestEndpoint::class)->uri("/users");
        $this->assertMethod($endpoint, 'uri', '/users');
    }

    /** @test */
    public function can_register_endpoint_deprecated()
    {
        $endpoint = Apidocs::register(TestEndpoint::class)->deprecated();
        $this->assertMethod($endpoint, 'deprecated', true);
    }

    /** @test */
    public function can_register_endpoint_query()
    {
        $this->endpoint_params('query', 'query');
    }

    /** @test */
    public function can_register_endpoint_params()
    {
        $this->endpoint_params('params', 'params');
    }

    /** @test */
    public function can_register_endpoint_body()
    {
        $endpoint = Apidocs::register(TestEndpoint::class)->body([
            Param::int('a'),
            Param::string('b'),
        ]);

        $this->assertMethod($endpoint, 'body', [
            'format' => '',
            'data' => [
                'a' => [
                    'type' => 'int',
                    'name' => 'a',
                ],
                'b' => [
                    'type' => 'string',
                    'name' => 'b',
                ]
            ]
        ]);
    }

    /** @test */
    public function can_register_endpoint_header()
    {
        $endpoint = Apidocs::register(TestEndpoint::class)->header('a', 'b');

        $this->assertMethod($endpoint, 'headers', [
            'a' => 'b',
        ]);
    }

    /** @test */
    public function can_register_endpoint_headers()
    {
        $endpoint = Apidocs::register(TestEndpoint::class)->headers([
            'a' => 'b',
            'c' => 'd',
        ]);

        $this->assertMethod($endpoint, 'headers', [
            'a' => 'b',
            'c' => 'd',
        ]);
    }

    /** @test */
    public function can_register_endpoint_example()
    {
        $endpoint = Apidocs::register(TestEndpoint::class)->example([
            'a' => 'b',
        ], 'title');

        $this->assertMethod($endpoint, 'examples', [
            [
                'title' => 'title',
                'data' => [
                    'a' => 'b',
                ]
            ]
        ]);
    }

    /** @test */
    public function can_register_endpoint_examples()
    {
        $endpoint = Apidocs::register(TestEndpoint::class)->examples([
            [
                'a' => 'b',
            ],
            [
                'c' => 'd',
            ]
        ]);

        $this->assertMethod($endpoint, 'examples', [
            [
                'title' => NULL,
                'data' => [
                    'a' => 'b',
                ]
            ],
            [
                'title' => NULL,
                'data' => [
                    'c' => 'd',
                ]
            ]
        ]);
    }

    /** @test */
    public function can_register_endpoint_returns()
    {
        $endpoint = Apidocs::register(TestEndpoint::class)->returns(200, [
            'status' => 'OK',
        ], 'desc');

        $this->assertMethod($endpoint, 'returns', [
            200 => [
                'response' => [
                    'status' => 'OK',
                ],
                'description' => 'desc'
            ]
        ]);
    }

    /** @test */
    public function can_register_endpoint_returns_magic()
    {
        $endpoint = Apidocs::register(TestEndpoint::class)->returns201([
            'status' => 'OK',
        ], 'desc');

        $this->assertMethod($endpoint, 'returns', [
            201 => [
                'response' => [
                    'status' => 'OK',
                ],
                'description' => 'desc'
            ]
        ]);
    }

    /** @test */
    public function can_defer()
    {
        Apidocs::defer([
            'endpoint.one' => TestEndpoint::class,
        ]);
        $this->assertCount(1, Apidocs::getDefered());

        Apidocs::defer([
            'endpoint.one' => TestEndpoint::class,
        ]);
        $this->assertCount(1, Apidocs::getDefered());

        Apidocs::defer([
            'endpoint.two' => TestEndpoint::class,
        ]);
        $this->assertCount(2, Apidocs::getDefered());

        $this->assertSame(json_encode([
            'endpoint.one' => TestEndpoint::class,
            'endpoint.two' => TestEndpoint::class,
        ]), json_encode(Apidocs::getDefered()));
    }

    /** @test */
    public function apidocs_function()
    {
        apidocs([
            'endpoint.one' => TestEndpoint::class,
        ]);
        $this->assertCount(1, Apidocs::getDefered());

        apidocs([
            'endpoint.one' => TestEndpoint::class,
        ]);
        $this->assertCount(1, Apidocs::getDefered());

        apidocs([
            'endpoint.two' => TestEndpoint::class,
        ]);
        $this->assertCount(2, Apidocs::getDefered());

        $this->assertSame(json_encode([
            'endpoint.one' => TestEndpoint::class,
            'endpoint.two' => TestEndpoint::class,
        ]), json_encode(Apidocs::getDefered()));
    }

    protected function assertMethod($endpoint, $field, $val)
    {
        $this->assertEquals([
            $field => $val
        ], $endpoint->data());
    }

    protected function endpoint_params($method, $prop)
    {
        $endpoint = Apidocs::register(TestEndpoint::class)->{$method}([
            Param::int('a'),
            Param::string('b'),
        ]);

        $this->assertMethod($endpoint, $prop, [
            'a' => [
                'type' => 'int',
                'name' => 'a',
            ],
            'b' => [
                'type' => 'string',
                'name' => 'b',
            ]
        ]);
    }
}
