<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // columns

        $this->crud->addClause("where", "role", "!=", User::ADMIN);
        $this->crud->removeButtons(["create", "show", "delete"]);

        if(!backpack_user()->canAdministrate()){
            $this->crud->addClause("where", "id", "=", backpack_user()->id);
        }

        $this->crud->addColumn([
            "label" => __("Name"),
            "type" => "text",
            "name" => "name"
        ]);

        $this->crud->addColumn([
            "label" => __("Email"),
            "type" => "email",
            "name" => "email"
        ]);

        $this->crud->addColumn([
            "label" => __("Phone"),
            "type" => "phone",
            "name" => "phone"
        ]);

        $this->crud->addColumn([
            "label" => __("Login Status"),
            "type" => "enum",
            "name" => "login_status"
        ]);

        $this->crud->addColumn([
            "label" => __("Activation status"),
            "type" => "enum",
            "name" => "activation_status"
        ]);
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserRequest::class);

        //CRUD::setFromDb(); // fields

        $this->crud->addField([
            "label" => __("Name"),
            "type" => "text",
            "name" => "name"
        ]);

        $this->crud->addField([
            "label" => __("User Name"),
            "type" => "text",
            "name" => "username"
        ]);

        $this->crud->addField([
            "label" => __("Email"),
            "type" => "email",
            "name" => "email"
        ]);

        $this->crud->addField([
            "label" => __("Phone"),
            "type" => "text",
            "name" => "phone"
        ]);


        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
