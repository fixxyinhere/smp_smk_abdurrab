<?php
// File: app/Models/RequestItemModel.php (FIXED VERSION)
namespace App\Models;

use CodeIgniter\Model;

class RequestItemModel extends Model
{
    protected $table = 'request_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['request_id', 'item_id', 'quantity', 'notes'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Add validation rules
    protected $validationRules = [
        'request_id' => 'required|integer',
        'item_id' => 'required|integer',
        'quantity' => 'required|integer|greater_than[0]'
    ];

    protected $validationMessages = [
        'request_id' => [
            'required' => 'Request ID is required',
            'integer' => 'Request ID must be an integer'
        ],
        'item_id' => [
            'required' => 'Item ID is required',
            'integer' => 'Item ID must be an integer'
        ],
        'quantity' => [
            'required' => 'Quantity is required',
            'integer' => 'Quantity must be an integer',
            'greater_than' => 'Quantity must be greater than 0'
        ]
    ];

    public function getRequestItems($requestId)
    {
        try {
            return $this->select('request_items.*, items.name as item_name, items.code as item_code')
                ->join('items', 'items.id = request_items.item_id', 'left')
                ->where('request_id', $requestId)
                ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'getRequestItems error: ' . $e->getMessage());
            return [];
        }
    }

    public function deleteByRequestId($requestId)
    {
        try {
            return $this->where('request_id', $requestId)->delete();
        } catch (\Exception $e) {
            log_message('error', 'deleteByRequestId error: ' . $e->getMessage());
            return false;
        }
    }

    // Add custom insert method with better error handling
    public function insertRequestItem($data)
    {
        try {
            // Validate data
            if (empty($data['request_id']) || empty($data['item_id']) || empty($data['quantity'])) {
                log_message('error', 'RequestItemModel: Missing required fields in data: ' . json_encode($data));
                return false;
            }

            // Ensure data types
            $data['request_id'] = (int) $data['request_id'];
            $data['item_id'] = (int) $data['item_id'];
            $data['quantity'] = (int) $data['quantity'];

            log_message('debug', 'RequestItemModel: Inserting data: ' . json_encode($data));

            $result = $this->insert($data);

            if ($result) {
                log_message('debug', 'RequestItemModel: Insert successful, ID: ' . $result);
            } else {
                log_message('error', 'RequestItemModel: Insert failed, errors: ' . json_encode($this->errors()));
            }

            return $result;
        } catch (\Exception $e) {
            log_message('error', 'RequestItemModel insertRequestItem error: ' . $e->getMessage());
            return false;
        }
    }
}
