<?php

namespace Controllers\SystemDemoRony;

use Controllers\PublicController;
use Views\Renderer;
use Dao\SystemDemoRony\SystemDemoRony as SystemDemoRonyDAO;

class SystemDemoRony extends PublicController
{
    public function run(): void
    {
        $viewData = [];

        $tmpSystemDemoRony = SystemDemoRonyDAO::obtenerSystemDemoRony();

        $viewData["demos"] = [];

        foreach ($tmpSystemDemoRony as $SystemDemoRony) {
            $SystemDemoRonyNormalizado = $SystemDemoRony;
            $viewData["demos"][] = $SystemDemoRonyNormalizado;
        }

        $viewData["total"] = count($viewData["demos"]);

        Renderer::render("SystemDemoRony/lista", $viewData);
    }
}
