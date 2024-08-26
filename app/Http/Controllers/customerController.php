<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class customerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        if ($customers->isEmpty()) {
            $data = [
                'message' => 'There are no customers',
                'status' => 200
            ];
            return response()->json($data, 404);
        }

        return response()->json($customers, 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:customer',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,Portuguese',
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error in data validation',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language,
        ]);

        if (!$customer) {
            $data = [
                'message' => 'Error creating customer',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'customer' => $customer,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            $data = [
                'message' => 'Customer not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'customer' => $customer,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            $data = [
                'message' => 'Customer not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $customer->delete();

        $data = [
            'message' => 'Customer deleted',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            $data = [
                'message' => 'Customer not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:customer',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,Portuguese'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->language = $request->language;

        $customer->save();

        $data = [
            'message' => 'Customer updated',
            'customer' => $customer,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            $data = [
                'message' => 'Customer not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:customer',
            'phone' => 'digits:10',
            'language' => 'in:English,Spanish,Portuguese'

        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('name')) {
            $customer->name = $request->name;
        }

        if ($request->has('email')) {
            $customer->email= $request->email;
        }

        if ($request->has('phone')) {
            $customer->phone = $request->phone;
        }

        if ($request->has('language')) {
            $customer->language= $request->language;
        }

        $customer->save();

        $data = [
            'message' => 'Customer updated',
            'customer' => $customer,
            'status' => 200
        ];

        return response() -> json($data, 200);
    }
}
