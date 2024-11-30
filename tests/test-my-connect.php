<?php 
/* test file */
use WP_UnitTesters\Testers\Testers;
class MyConnectTest extends WP_UnitTestCase {
    public function test_send_connection_request() {
        $response = $this->call_api('/wp-json/my-connect/v1/send', 'POST', ['user_id_2' => 2]);
        $this->assertEquals(200, $response->status);
    }
}
