<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\SetLocale;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class SetLocaleTest extends TestCase
{
    use RefreshDatabase;

    private $middleware;
    private MockHandler $responsesMock;
    private HandlerStack $handlerStack;
    private Client $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->middleware = new SetLocale();
        $this->responsesMock = new MockHandler([
            //            new Response(202, ['Content-Length' => 0]),
            //new RequestException('Error Communicating with Server', new Request('GET', 'test'))
        ]);
        $this->handlerStack = HandlerStack::create($this->responsesMock);
        $this->client = new Client(['handler' => $this->handlerStack]);
    }

    /**
     * @test
     * @dataProvider getIpData()
     **/
    public function it_gets_the_default_language_of_a_not_logged_user_by_checking_its_ip_if_session_has_no_language_set(
        $ip,
        $responseBody,
    ) {
        $this->assertNull(session('locale'));
        $this->responsesMock->append(new Response(200, [], $responseBody));
        $locale = $this->middleware->getCountryIp($ip, $this->client);
        $this->assertEquals('it', $locale);
    }

    /**
     * @test
     *
     **/
    public function it_checks_if_country_ip_is_not_discoverable()
    {
        $this->responsesMock->reset();
        $this->responsesMock->append(
            new Response(
                404,
                [],
                '{
	                                                                    "status": 404,
	                                                                    "error": {
	                                                                    	"title": "Wrong ip",
	                                                                    	"message": "Please provide a valid IP address"
	                                                                   }',
            ),
        );
        $country = $this->middleware->getCountryIp('WRONG_IP', $this->client);
        $this->assertNull($country);
    }

    /** @test **/
    public function it_sets_the_default_language_of_a_logged_user_by_checking_its_settings_if_session_has_no_language_set()
    {
        $this->signIn();
        session()->remove('locale');
        $this->assertNull(session('locale'));

        $newLocale = 'it';
        $this->user->settings()->update(['defaultLanguage' => $newLocale]);

        $request = Request::create(route('dashboard'));
        $dashboardResponse = $this->get(route('dashboard'));
        $response = $this->middleware->handle($request, function () use ($dashboardResponse) {
            return $dashboardResponse;
        });

        $response->assertSessionHas('locale', $newLocale);
        $this->assertEquals($this->app->getLocale(), $newLocale);
    }

    public function getIpData()
    {
        return [
            [
                'ip' => '79.49.176.238',
                'responseBody' => '{
	                                    "ip": "79.49.176.238",
	                                    "hostname": "host-79-49-176-238.retail.telecomitalia.it",
	                                    "city": "Rome",
	                                    "region": "Latium",
	                                    "country": "IT",
	                                    "loc": "41.9751,12.5149",
	                                    "org": "AS3269 Telecom Italia S.p.A.",
	                                    "postal": "00138",
	                                    "timezone": "Europe/Rome",
	                                    "readme": "https://ipinfo.io/missingauth"
                                   }',
            ],
        ];
    }
}
