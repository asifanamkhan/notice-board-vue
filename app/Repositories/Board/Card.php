<?php

namespace App\Repositories\Board;

use Illuminate\Validation\Rule;
use App\Models\Board\Card as Model;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;

class Card extends BaseRepository
{
    protected static $model = Model::class;
    

    protected static $rules = [
        'save' => [
            'column_id' => 'required|integer',
            'title' => 'required|unique:cards'
        ],
        'update' => []
    ];

    public static function save($data): array
    {
        static::$rules['save']['order'] = [
            'required',
            'integer',
            Rule::unique('cards')->where(function ($query) use ($data) {
                return $query->where('order', $data['order'])->where('column_id', $data['column_id']);
            })
        ];

        return parent::save($data);
    }

    public static function update($id, $data): array
    {

        static::$rules['update'] = [
            'column_id' => 'required|integer',
            'order' => [
                'required',
                'integer',
                Rule::unique('cards')->where(function ($query) use ($data) {
                    return $query->where('order', $data['order'])->where('column_id', $data['column_id']);
                })->ignore($id)
            ],
            'title' => 'required|unique:cards,id,' . $id
        ];

        return parent::update($id, $data);
    }

    /**
     * Get models.
     * 
     * @param   integer $column_id
     * 
     * @return array
     * 
     */
    public static function getMaxOrder($column_id): array
    {
        try {
            // Get Max Order
            $order = Model::where('column_id', $column_id)->max('order');


            return [
                'status' => 'success',
                'data' => $order
            ];
        } catch (Exception $ex) {
            return [
                'status' => 'error',
                'data' => $ex->getMessage()
            ];
        }
    }

    public static function swap($data)
    {
        try {
            // Check validation.
            $validator = Validator::make($data, [
                'column_id' => 'required',
                'from' => 'required',
                'to' => 'required'
            ]);
            // If validation failed then return the error.
            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'data' => $validator->errors()->toArray()
                ];
            }

            $current = Model::whereColumnId($data['column_id'])->whereOrder($data['from'])->first();
            $target = Model::whereColumnId($data['column_id'])->whereOrder($data['to'])->first();

            $current->order = $data['to'];
            $current->save();

            $target->order = $data['from'];
            $target->save();
            
 
            return [
                'status' => 'success',
                'data' => $current
            ];
        } catch (Exception $ex) {
            return [
                'status' => 'error',
                'data' => $ex->getMessage()
            ];
        }
    }
}