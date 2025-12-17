<?php

namespace Controllers\SystemDemoRony;

use Controllers\PublicController;
use Utilities\Site;
use Dao\SystemDemoRony\SystemDemoRony as DAOSystemDemoRony;
use Utilities\Validators;
use Views\Renderer;
use Exception;

const SystemDemoRonyList = "index.php?page=SystemDemoRony";
const SystemDemoRonyView = "SystemDemoRony/form";

class SystemDemoRony extends PublicController
{
    private array $errores = [];

    private $modes = [
        "INS" => "Nuevo Demo",
        "UPD" => "Editando %s",
        "DSP" => "Detalle de %s",
        "DEL" => "Eliminando %s"
    ];

    private string $mode = '';
    private string $id_demo = '';
    private string $nombre_demo = '';
    private string $descripcion = '';
    private string $version_sistema = '';
    private string $fecha_demo = '';

    private string $validationToken = "";

    public function run(): void
    {
        try {
            $this->page_init();

            if ($this->isPostBack()) {
                $this->errores = $this->validarPostData();

                if (count($this->errores) === 0) {
                    try {
                        switch ($this->mode) {
                            case "INS":
                                $affectedRows = DAOSystemDemoRony::crearSystemDemoRony(
                                    $this->nombre_demo,
                                    $this->descripcion,
                                    $this->version_sistema,
                                    $this->fecha_demo
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(SystemDemoRonyList, "Demo creado correctamente");
                                }
                                break;

                            case "UPD":
                                $affectedRows = DAOSystemDemoRony::actualizarSystemDemoRony(
                                    $this->id_demo,
                                    $this->nombre_demo,
                                    $this->descripcion,
                                    $this->version_sistema,
                                    $this->fecha_demo
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(SystemDemoRonyList, "Demo actualizado correctamente");
                                }
                                break;

                            case "DEL":
                                $affectedRows = DAOSystemDemoRony::eliminarSystemDemoRony(
                                    $this->id_demo
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(SystemDemoRonyList, "Demo eliminado correctamente");
                                }
                                break;
                        }
                    } catch (Exception $err) {
                        error_log($err->getMessage());
                    }
                }
            }

            Renderer::render(SystemDemoRonyView, $this->preparar_datos_vista());
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(SystemDemoRonyList, "Ocurrió un error. Intente nuevamente.");
        }
    }

    private function page_init(): void
    {
        if (!isset($_GET["mode"]) || !isset($this->modes[$_GET["mode"]])) {
            throw new Exception("Modo inválido");
        }

        $this->mode = $_GET["mode"];

        if ($this->mode !== "INS") {
            if (!isset($_GET["id"]) || empty($_GET["id"])) {
                throw new Exception("ID inválido");
            }

            $tmpId = $_GET["id"];
            $tmpDemo = DAOSystemDemoRony::obtenerSystemDemoRonyPorId($tmpId);

            if (!$tmpDemo) {
                throw new Exception("Registro no encontrado");
            }

            $this->id_demo = $tmpDemo["id_demo"];
            $this->nombre_demo = $tmpDemo["nombre_demo"];
            $this->descripcion = $tmpDemo["descripcion"];
            $this->version_sistema = $tmpDemo["version_sistema"];
            $this->fecha_demo = $tmpDemo["fecha_demo"];
        }
    }

    private function validarPostData(): array
    {
        $errors = [];

        $this->validationToken = $_POST["vlt"] ?? "";

        if (isset($_SESSION[$this->name . "_token"]) &&
            $_SESSION[$this->name . "_token"] !== $this->validationToken) {
            throw new Exception("Error de validación de token");
        }

        $this->id_demo = $_POST["id_demo"] ?? '';
        $this->nombre_demo = $_POST["nombre_demo"] ?? '';
        $this->descripcion = $_POST["descripcion"] ?? '';
        $this->version_sistema = $_POST["version_sistema"] ?? '';
        $this->fecha_demo = $_POST["fecha_demo"] ?? '';

        if (Validators::IsEmpty($this->nombre_demo)) {
            $errors[] = "Nombre del demo no puede estar vacío";
        }

        if (Validators::IsEmpty($this->version_sistema)) {
            $errors[] = "Versión del sistema requerida";
        }

        return $errors;
    }

    private function generarTokenDeValidacion()
    {
        $this->validationToken = md5(gettimeofday(true) . $this->name . rand(1000, 9999));
        $_SESSION[$this->name . "_token"] = $this->validationToken;
    }

    private function preparar_datos_vista(): array
    {
        $viewData = [];

        $viewData["mode"] = $this->mode;
        $viewData["modeDsc"] = $this->modes[$this->mode];

        if ($this->mode !== "INS") {
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->nombre_demo);
        }

        $viewData["id_demo"] = $this->id_demo;
        $viewData["nombre_demo"] = $this->nombre_demo;
        $viewData["descripcion"] = $this->descripcion;
        $viewData["version_sistema"] = $this->version_sistema;
        $viewData["fecha_demo"] = $this->fecha_demo;

        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->validationToken;

        $viewData["errores"] = $this->errores;
        $viewData["hasErrores"] = count($this->errores) > 0;

        $viewData["idReadonly"] = $this->mode !== "INS" ? "readonly" : "";
        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";
        $viewData["isDisplay"] = $this->mode === "DSP";

        return $viewData;
    }
}
