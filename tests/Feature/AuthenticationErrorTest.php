<?php
//
//namespace Tests\Feature;
//
//use Tests\TestCase;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//
//class AuthenticationErrorTest extends TestCase
//{
//    use RefreshDatabase;
//
//    public function test_accessing_secure_endpoint_without_token_returns_proper_error()
//    {
//        $response = $this->getJson('/api/deliveries');
//
//        $response->assertStatus(401)
//                ->assertJson([
//                    'status' => 'error',
//                    'message' => 'Authorization header is required',
//                    'code' => 'authorization_header_missing'
//                ])
//                ->assertJsonStructure([
//                    'status',
//                    'message',
//                    'code',
//                    'details'
//                ]);
//    }
//
//    public function test_accessing_secure_endpoint_with_invalid_auth_format_returns_proper_error()
//    {
//        $response = $this->withHeaders([
//            'Authorization' => 'InvalidFormat token123'
//        ])->getJson('/api/deliveries');
//
//        $response->assertStatus(401)
//                ->assertJson([
//                    'status' => 'error',
//                    'message' => 'Invalid authorization format',
//                    'code' => 'invalid_authorization_format'
//                ])
//                ->assertJsonStructure([
//                    'status',
//                    'message',
//                    'code',
//                    'details'
//                ]);
//    }
//
//    public function test_accessing_secure_endpoint_with_invalid_token_returns_proper_error()
//    {
//        $response = $this->withHeaders([
//            'Authorization' => 'Bearer invalid_token_here'
//        ])->getJson('/api/deliveries');
//
//        $response->assertStatus(401)
//                ->assertJson([
//                    'status' => 'error',
//                    'message' => 'JWT token is invalid',
//                    'code' => 'token_invalid'
//                ])
//                ->assertJsonStructure([
//                    'status',
//                    'message',
//                    'code',
//                    'details'
//                ]);
//    }
//
//    public function test_accessing_secure_endpoint_with_malformed_token_returns_proper_error()
//    {
//        $response = $this->withHeaders([
//            'Authorization' => 'Bearer malformed.token.here'
//        ])->getJson('/api/deliveries');
//
//        $response->assertStatus(401)
//                ->assertJson([
//                    'status' => 'error',
//                    'message' => 'JWT token not found or malformed',
//                    'code' => 'token_not_found'
//                ])
//                ->assertJsonStructure([
//                    'status',
//                    'message',
//                    'code',
//                    'details'
//                ]);
//    }
//
//    public function test_accessing_menu_endpoint_without_token_returns_proper_error()
//    {
//        $response = $this->getJson('/api/menus');
//
//        $response->assertStatus(401)
//                ->assertJson([
//                    'status' => 'error',
//                    'message' => 'Authorization header is required',
//                    'code' => 'authorization_header_missing'
//                ])
//                ->assertJsonStructure([
//                    'status',
//                    'message',
//                    'code',
//                    'details'
//                ]);
//    }
//
//    public function test_accessing_secure_endpoint_with_empty_bearer_returns_proper_error()
//    {
//        $response = $this->withHeaders([
//            'Authorization' => 'Bearer '
//        ])->getJson('/api/deliveries');
//
//        $response->assertStatus(401)
//                ->assertJson([
//                    'status' => 'error',
//                    'message' => 'JWT token not found or malformed',
//                    'code' => 'token_not_found'
//                ])
//                ->assertJsonStructure([
//                    'status',
//                    'message',
//                    'code',
//                    'details'
//                ]);
//    }
//}
