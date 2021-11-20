<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Http\Response;


class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $client, $admin;

    private Generator $faker;


    public function setUp(): void
    {
        parent::setUp();

        $this->setupPermissions();

        $this->faker = Factory::create();

        $this->member = User::create([
            'name' => 'Member',
            'email' => 'user1@user.com',
            'password' => bcrypt('password'),
        ]);

        $this->client = User::create([
            'name' => 'client',
            'email' => 'user2@user.com',
            'password' => bcrypt('password'),
        ]);

        $this->client->assignRole('client');

        $this->admin = User::create([
            'name' => 'admin',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
        ]);

        $this->admin->assignRole('super');

        

    }

    protected function setupPermissions()
    {
        Permission::findOrCreate('view-home');
        Permission::findOrCreate('view-dashboard');
        Permission::findOrCreate('view-post');
        Permission::findOrCreate('upload-photo');

        Role::findOrCreate('super');

        Role::findOrCreate('client')->givePermissionTo(['view-home', 'view-post']);
         
       
        $this->app->make(PermissionRegistrar::class)->registerPermissions();
    }


    
   
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }




    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_login()
    {
        
        $response = $this->actingAs($this->admin, 'users')
        ->json('post', '/api/auth/login', [
            'email' => 'user@user.com',
            'password' => 'password'
        ]);

     
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'name'
            ]
        ]);

        $response->assertStatus(200);
    }



    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_super_has_all_permissions()
    {
      
        $permissions = permission::all()->pluck('name')->toArray();

        foreach ($permissions as $permission) {
            $this->assertTrue($this->admin->hasPermissionTo($permission));
        }

        permission::findOrCreate('new Permission');

        $this->assertTrue($this->admin->hasPermissionTo('new Permission'));
   
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_member_has_no_permissions()
    {

        $permissions = permission::all()->pluck('name')->toArray();

        foreach ($permissions as $permission) {
            $this->assertFalse($this->member->hasPermissionTo($permission));
        }
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_client_has_some_permissions()
    {

        $this->assertTrue($this->client->hasPermissionTo('view-home'));
        $this->assertTrue($this->client->hasPermissionTo('view-post'));
        $this->assertFalse($this->client->hasPermissionTo('view-dashboard'));
        $this->assertFalse($this->client->hasPermissionTo('upload-photo'));
      
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_client_can_not_view_dashboard()
    {
        $response = $this->actingAs($this->client, 'users')
        ->json('get', '/api/page/dashboard');

        $response->assertStatus(Response::HTTP_FORBIDDEN);



        $this->client->givePermissionTo('view-dashboard');

        $response = $this->actingAs($this->client, 'users')
        ->json('get', '/api/page/dashboard');

        $response->assertStatus(Response::HTTP_OK);

    }



    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_admin_can_view_dashboard()
    {
        $response = $this->actingAs($this->admin, 'users')
        ->json('get', '/api/page/dashboard');

        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_assign_permission_to_role()
    {
        $role = Role::findOrCreate('my-role');
        $permission = Permission::findOrCreate('my-permission');
        $role->givePermissionTo($permission);

        $this->assertTrue($role->hasPermissionTo($permission));
    }



    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_assign_permission_to_role_assigned_before_to_user()
    {

        $user =User::factory()->create();

        $role = Role::findOrCreate('new-role');
        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $permission = Permission::create(['name' => 'new-permission']);
        $role->givePermissionTo($permission->name);


       $this->assertTrue( $user->hasPermissionTo($permission->name));
    }

}
