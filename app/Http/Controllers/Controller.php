<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function filter($model, array $fields = [], array $fieldsLike = [], array $where = [])
    {
        $query = $model::query();

        if (!empty($fields)) {
            foreach ($fields as $field) {
                if (request($field)) {
                    $query->where($field, request($field));
                }
            }
        }

        if (!empty($fieldsLike)) {
            foreach ($fieldsLike as $field) {
                if (request($field)) {
                    $query->where($field, 'like', '%' . request($field) . '%');
                }
            }
        }

        if (!empty($where)) {
            $query = $query->where($where);
        }

        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');
        return $query->orderBy($sortField, $sortDirection)->paginate(10)->onEachSide(1);
    }
}
