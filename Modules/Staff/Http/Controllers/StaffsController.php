<?php

namespace Modules\Staff\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Staff\Repositories\StaffRepository;
use Modules\Staff\Transformers\StaffProfileTransformer;
use Modules\Staff\Transformers\StaffTransformer;

class StaffsController extends Controller
{
    /**
     * @var StaffRepository
     */
    private $staffRepository;

    /**
     * StaffsController constructor.
     * @param StaffRepository $staffRepository
     */
    public function __construct(StaffRepository $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }

    public function getStaffs()
    {
        $staffs = $this->staffRepository->getStaffs();

        return transform($staffs, new StaffTransformer());
    }

    public function fetchStaff($staff_id)
    {
        $staff = $this->staffRepository->findById($staff_id);

        return transform($staff, new StaffProfileTransformer());
    }
}
