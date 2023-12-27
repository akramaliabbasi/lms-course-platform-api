<?php

namespace App\Http\Controllers\API\V1; 

use App\Http\Controllers\Controller;
use App\Http\Resources\EnrolmentResource;
use App\Models\Enrolment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @OA\Info(
 *     title="My First API",
 *     version="0.1"
 * )
 */
class EnrolmentController extends Controller
{
	/**
     * EnrolmentController constructor.
     *
     * @param Enrolment $enrolment
     */
    public function __construct(Enrolment $enrolment)
    {
        $this->enrolment = $enrolment;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/enrolments",
     *     summary="Create a new enrolment record for a user in a specific course.",
     *     @OA\RequestBody(
     *         required=true,
     *         
     *     ),
     *     @OA\Response(response="200", description="Enrolment created successfully")),
     * )
     */
    public function create(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $enrolment = Enrolment::create($request->all());

        return response()->json(['message' => 'Enrolment created successfully', 'data' => new EnrolmentResource($enrolment)]);
    }
	
	/**
     * @OA\Post(
     *     path="/api/v1/enrolments/store",
     *     summary="Create a new enrolment record with uniqueness validation.",
     *     @OA\RequestBody(
     *         required=true,
     *         
     *     ),
     *     @OA\Response(response="200", description="Enrolment created successfully")),
     * )
     */
	public function store(Request $request)
	{
		$request->validate([
			'user_id' => [
				'required',
				'exists:users,id',
				Rule::unique('enrolments')->where(function ($query) use ($request) {
					return $query->where('user_id', $request->user_id)
						->where('course_id', $request->course_id);
				}),
			],
			'course_id' => 'required|exists:courses,id',
		]);

		try {
			$enrolment = Enrolment::create($request->all());
			return new EnrolmentResource($enrolment);
		} catch (\Exception $e) {
			return response()->json(['message' => 'Error creating enrolment', 'error' => $e->getMessage()], 500);
		}
	}


    /**
     * @OA\Put(
     *     path="/api/v1/enrolments/{id}",
     *     summary="Update the status of a user's enrolment (e.g., from active to completed).",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Enrolment ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(response="200", description="Enrolment updated successfully"),
   
     * )
     */
    public function update(Request $request, $id)
    {
		
        $request->validate([
            'status' => 'required|in:active,completed',
        ]);

        $enrolment = Enrolment::find($id);

        if (!$enrolment) {
            return response()->json(['message' => 'Enrolment not found'], 404);
        }

        $enrolment->update(['status' => $request->status]);

        return response()->json(['message' => 'Enrolment updated successfully', 'data' => new EnrolmentResource($enrolment)]);
    }

	
	/**
     * @OA\Get(
     *     path="/api/v1/enrolments/{id}",
     *     summary="Retrieve details of a specific user's enrolment in a course.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Enrolment ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Enrolment details")),
    * )
     */
	public function show($id)
	{
		// Retrieve the enrolment with related user and course using eager loading
		$enrolment = $this->enrolment->with('user', 'course')->find($id);

		// Check if the enrolment was not found
		if (!$enrolment) {
			// Return a JSON response with a 404 status code and a message
			return response()->json(['message' => 'Enrolment course not found'], 404);
		}

		// Transform the enrolment data using the EnrolmentResource
		return new EnrolmentResource($enrolment);
	}


	 /**
     * @OA\Get(
     *     path="/api/v1/enrolments/list",
     *     summary="Retrieve a list of all enrolments for a specific course or all enrolments for a specific user.",
     *     @OA\Parameter(
     *         name="course_id",
     *         in="query",
     *         description="Course ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="List of enrolments")),
     * )
     */
	public function listEnrolments(Request $request)
	{
		if ($request->has('course_id')) {
			$enrolments = Enrolment::where('course_id', $request->course_id)->get();
		} elseif ($request->has('user_id')) {
			$enrolments = Enrolment::where('user_id', $request->user_id)->get();
		} else {
			$enrolments = Enrolment::all();
		}

		return EnrolmentResource::collection($enrolments);
	}




	/**
     * @OA\Get(
     *     path="/api/v1/enrolments",
     *     summary="Display a paginated list of enrolments.",
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items to display per page",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Paginated list of enrolments"),
     * )
     */
	public function index(Request $request)
	{
		// Get the number of items to display per page from the request (default: 10)
		$perPage = $request->input('per_page', 10);

		// Retrieve paginated enrolments with related user and course using eager loading
		$enrolments = $this->enrolment->with('user', 'course')->paginate($perPage);

		// Transform the paginated enrolment data using EnrolmentResource
		return EnrolmentResource::collection($enrolments);
	}

}
