<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 11/05/2017
 * Time: 10:55 AM
 */

namespace Modules\Staff\Repositories;

use Modules\Staff\Events\StaffWasAdded;
use Modules\Staff\Models\Staff;

class StaffRepository
{
    /**
     * @var Staff
     */
    private $staff;

    /**
     * StaffRepository constructor.
     * @param Staff $staff
     */
    public function __construct(Staff $staff)
    {
        $this->staff = $staff;
    }

    public function saveStaff(array $payLoad){
        // we are editing a staff if we supply the staff's id
        $editMode = isset($payLoad['id']) ? true : false;

        /**
         * @var Staff $staff
         */
        $staff = $this->staff->firstOrNew([
            'id' => $editMode ? $payLoad['id'] : null
        ]);

        $staff->fill([
            'first_name' => $payLoad['firstName'],
            'last_name' => $payLoad['lastName'],
            'phone' => $payLoad['phone'],
            'username' => $payLoad['username'],
            'email' => $payLoad['email'],
            'active' => isset($payLoad['active']) ? $payLoad['active'] : false,
        ]);

        if(!$editMode){
            $staff->fill([
                'api_token' => str_random(60),
            ]);
        }

        if(isset($payLoad['password'])) $staff->fill(['password' => bcrypt($payLoad['password'])]);

        $staff->save();

        // fire an event when creating a new staff
        if(!$editMode) event(new StaffWasAdded($staff, $payLoad));

        return $staff;
    }

    public function getStaffs()
    {
        return $this->staff->latest()->get();
    }

    /**
     * @param $staff_id
     * @return Staff
     */
    public function findById($staff_id)
    {
        return $this->staff->find($staff_id);
    }
}