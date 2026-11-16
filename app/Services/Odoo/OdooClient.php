<?php 

    namespace App\Services;

    use Obuchmann\OdooJsonRpc\Odoo;

    use Obuchmann\OdooJsonRpc\Odoo\Request\Arguments\Domain;

    class OdooClient
    {
        protected Odoo $odoo;

        public function __construct(Odoo $odoo)
        {
            $odoo->connect();
            $this->odoo = $odoo;
        }

        /**
         * Obtener registros de cualquier modelo de Odoo con filtros opcionales.
         */
        public function getRecords(string $model, ?Domain $domain = null, array $fields = [], int $limit = 0): array
        {
            return $this->odoo->searchRead(
                model: $model,
                domain: $domain,
                fields: $fields,
                limit: $limit
            );
        }

        /**
         * Crear un registro en Odoo
         */
        public function createRecord(string $model, array $data): int
        {
            return $this->odoo->create($model, [$data]);
        }   

    }