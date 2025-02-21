<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Customer API Documentation",
 *     description="API documentation for Customer Management",
 *     @OA\Contact(
 *         email="your-email@example.com"
 *     )
 * )
 */

class CustomerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get list of customers",
     *     description="Returns paginated list of customers with filtering, sorting and pagination",
     *     operationId="getCustomersList",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="filter[first_name]",
     *         in="query",
     *         description="Filter by first name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="filter[last_name]",
     *         in="query",
     *         description="Filter by last name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="sort[first_name]",
     *         in="query",
     *         description="Sort by first name (asc/desc)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"asc", "desc"})
     *     ),
     *     @OA\Parameter(
     *         name="page[number]",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="page[size]",
     *         in="query",
     *         description="Items per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="customer_id", type="string"),
     *                     @OA\Property(property="first_name", type="string"),
     *                     @OA\Property(property="last_name", type="string"),
     *                     @OA\Property(property="company", type="string"),
     *                     @OA\Property(property="city", type="string"),
     *                     @OA\Property(property="country", type="string"),
     *                     @OA\Property(property="phone_1", type="string"),
     *                     @OA\Property(property="phone_2", type="string"),
     *                     @OA\Property(property="email", type="string"),
     *                     @OA\Property(property="subscription_date", type="string"),
     *                     @OA\Property(property="website", type="string")
     *                 )
     *             ),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="next_page_url", type="string"),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="prev_page_url", type="string"),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     *     @OA\SecurityScheme(
     *         securityScheme="basicAuth",
     *         type="http",
     *         scheme="basic"
     *     )
     */
    public function index(Request $request)
    {
        $query = Customer::query();
        if ($request->has('filter')) {
            foreach ($request->filter as $field => $value) {
                $query->where($field, 'like', "%$value%");
            }
        }
        if ($request->has('sort')) {
            foreach ($request->sort as $field => $direction) {
                $query->orderBy($field, $direction);
            }
        }
        $customers = $query->paginate(
            $request->input('page.size', 10),
            ['*'],
            'page[number]',
            $request->input('page.number', 1)
        );
        return response()->json($customers)->header('X-app-version', 'v1');
    }
}
