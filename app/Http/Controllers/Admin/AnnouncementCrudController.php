<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AnnouncementCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AnnouncementCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Announcement::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/announcement');
        CRUD::setEntityNameStrings('announcement', 'announcements');
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

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */

        $this->crud->addColumn([
            "name" => "title",
            "type" => "text",
            "label" => __("Announcement title")
        ]);

        $this->crud->addColumn([
            "name" => "content",
            "type" => "textarea",
            "label" => __("Announcement Content")
        ]);

        $this->crud->addColumn([
            "name" => "receiver",
            "type" => "select2_from_array",
            "options" => [
                Announcement::ALL => "All",
                Announcement::RH => "RH",
                Announcement::SH => "SH"
            ],
            "label" => __("Announcement Receiver")
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(AnnouncementRequest::class);

        //CRUD::setFromDb(); // fields

        $this->crud->addField([
           "name" => "title",
           "type" => "text",
           "label" => __("Announcement title")
        ]);

        $this->crud->addField([
            "name" => "content",
            "type" => "wysiwyg",
            "label" => __("Announcement Content")
        ]);

        $this->crud->addField([
            "name" => "receiver",
            "type" => "select2_from_array",
            "options" => [
                Announcement::ALL => "All",
                Announcement::RH => "RH",
                Announcement::SH => "SH"
            ],
            "label" => __("Announcement Receiver")
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
