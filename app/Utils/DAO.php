<?php

namespace App\Utils;

/**
 * Class DAO
 *
 * This class provides utility functions for interacting with the database
 * using Laravel's Eloquent ORM. It offers a reusable way to create
 * paginated JSON responses with eager loading of relationships for various
 * models in your application.
 */
class DAO
{
    /**
     * Creates a paginated JSON response with eager loading of relationships.
     *
     * @param  $model  The Eloquent model class to use for pagination.
     * @param  array  $relations  (optional) An array of relationship names to eager load.
     * @param  int  $perPage  (optional) The number of items per page for pagination (defaults to 50).
     * @return array
     */
    public static function paginateWithEagerLoading($model, array $relations = [], int $perPage = 50): array
    {
        $data = $model::with($relations)->paginate($perPage);

        $currentPage = $data->currentPage();
        $lastPage = $data->lastPage();

        return [
            'items' => $data->items(),
            'meta' => [
                'total' => $data->total(),
                'previous_page' => $currentPage > 1 ? $currentPage - 1 : 1,
                'current_page' => $currentPage,
                'next_page' => $currentPage < $lastPage ? $currentPage + 1 : $lastPage,
                'last_page' => $lastPage,
            ],
        ];
    }
}
