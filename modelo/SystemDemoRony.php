<?php

namespace Dao\SystemDemoRony;

use Dao\Table;

class SystemDemoRony extends Table {

    public static function obtenerSystemDemoRony(): array {

        $sqlstr = "SELECT * FROM system_demos";
        return self::obtenerRegistros($sqlstr, []);

    }

    public static function obtenerSystemDemoRonyPorId(string $id_demo): array
    {

        $sqlstr = "SELECT * FROM system_demos WHERE id_demo = :id_demo";
        return self::obtenerUnRegistro($sqlstr, [
            "id_demo" => $id_demo
        ]);

    }

    public static function crearSystemDemoRony(
        string $nombre_demo,
        string $descripcion,
        string $version_sistema,
        string $fecha_demo
    )
    {
        $insSql = "INSERT INTO system_demos
        (nombre_demo, descripcion, version_sistema, fecha_demo)
        VALUES
        (:nombre_demo, :descripcion, :version_sistema, :fecha_demo);";

        $newInsertData = [
            "nombre_demo"     => $nombre_demo,
            "descripcion"     => $descripcion,
            "version_sistema" => $version_sistema,
            "fecha_demo"      => $fecha_demo
        ];

        return self::executeNonQuery($insSql, $newInsertData);

    }

    public static function actualizarSystemDemoRony(
        string $id_demo,
        string $nombre_demo,
        string $descripcion,
        string $version_sistema,
        string $fecha_demo
    )
    {
        $updSql = "UPDATE system_demos SET
            nombre_demo = :nombre_demo,
            descripcion = :descripcion,
            version_sistema = :version_sistema,
            fecha_demo = :fecha_demo
        WHERE id_demo = :id_demo;";

        $newUpdateData = [
            "id_demo"         => $id_demo,
            "nombre_demo"     => $nombre_demo,
            "descripcion"     => $descripcion,
            "version_sistema" => $version_sistema,
            "fecha_demo"      => $fecha_demo
        ];

        return self::executeNonQuery($updSql, $newUpdateData);

    }

    public static function eliminarSystemDemoRony(string $id_demo)
    {
        $delSql = "DELETE FROM system_demos WHERE id_demo = :id_demo";

        $delParams = [
            "id_demo" => $id_demo
        ];

        return self::executeNonQuery($delSql, $delParams);
    }
}
