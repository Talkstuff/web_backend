<?php

namespace Modules\Controlpanel\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Controlpanel\Repositories\ModulesRepository;
use Modules\Controlpanel\Transformers\ModuleTransformer;

class ModulesController extends Controller
{
    /**
     * @var ModulesRepository
     */
    private $modulesRepository;

    /**
     * ModulesController constructor.
     * @param ModulesRepository $modulesRepository
     */
    public function __construct(ModulesRepository $modulesRepository)
    {
        $this->modulesRepository = $modulesRepository;
    }

    public function fetchModules()
    {
        $modules = $this->modulesRepository->fetchModules();

        return transform($modules, new ModuleTransformer());
    }

    public function installModule()
    {
        $this->modulesRepository->installModule();
    }
}
