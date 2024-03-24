<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Models\Notes;
use Illuminate\Support\Str;
use Validator;

class NotesController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * @OA\Get(
     * path="/api/notes",
     * tags={"Notes"},
     * summary="Get notes",
     * description="Display all data notes",
     *      @OA\Response(
     *          response=200,
     *          description="Fetch notes success",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean"),
     *              @OA\Property(
     *                  property="data", 
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string"),
     *                      @OA\Property(property="title", type="string"),
     *                      @OA\Property(property="description", type="string"),
     *                      @OA\Property(property="deleted_at", type="string"),
     *                      @OA\Property(property="created_at", type="string"),
     *                      @OA\Property(property="updated_at", type="string")
     *                  )
     *              ),
     *              @OA\Property(property="message", type="string")
     *          )
     *      )
     * )
     */
    public function index(Request $request) {
        $notes = Notes::orderBy('updated_at', 'desc')->get();
        
        return $this->sendResponse($notes, 'Fetch notes success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * @OA\Get(
     * path="/api/notes/{note_id}",
     * tags={"Notes"},
     * summary="Get note by ID",
     * description="Display specific note by ID",
     *  @OA\Parameter(
     *      description="ID of notes",
     *      in="path",
     *      name="note_id",
     *      required=true,
     *      example="da9081e0-b20b-4228-a605-4afa34b8e963",
     *      @OA\Schema(
     *          type="string",
     *          format="uuid"
     *      ),
     *  ),
     *      @OA\Response(
     *          response=200,
     *          description="Fetch notes success",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean"),
     *              @OA\Property(
     *                  property="data",
     *                  @OA\Property(property="id", type="string"),
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="description", type="string"),
     *                  @OA\Property(property="deleted_at", type="string"),
     *                  @OA\Property(property="created_at", type="string"),
     *                  @OA\Property(property="updated_at", type="string")
     *              ),
     *              @OA\Property(property="message", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", default="false"),
     *              @OA\Property(property="message", type="string", default="Not Found")
     *          )
     *      )
     * )
     */
    public function showById($id) {
        $notes = Notes::where('id', $id)->first();

        if (!$notes) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($notes, 'Fetch detail notes success');
    }

    /**
     * Insert new resource.
     *
     * @param  request  $request
     * @return \Illuminate\Http\Response
     * 
     * @OA\Post(
     * path="/api/notes",
     * tags={"Notes"},
     * summary="Create new note",
     * description="Insert new note data",
     *  @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "title":"example title",
     *                     "description":"example description"
     *                }
     *          )
     *      )
     *  ),
     *      @OA\Response(
     *          response=201,
     *          description="Submit notes success",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean"),
     *              @OA\Property(
     *                  property="data",
     *                  @OA\Property(property="id", type="string"),
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="description", type="string"),
     *                  @OA\Property(property="deleted_at", type="string"),
     *                  @OA\Property(property="created_at", type="string"),
     *                  @OA\Property(property="updated_at", type="string")
     *              ),
     *              @OA\Property(property="message", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Error Validation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", default="false"),
     *              @OA\Property(property="message", type="string", default="Error validation"),
     *              @OA\Property(
     *                  property="data", 
     *                  type="object",
     *                  @OA\Property(property="title", type="array", @OA\Items()),
     *                  @OA\Property(property="description", type="array", @OA\Items())
     *              )
     *          )
     *      )
     * )
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $input = $request->all();
        $input['id'] = Str::uuid();
        $create = Notes::create($input);

        return $this->sendResponse($create, "Submit notes success", 201);
    }

    /**
     * Modified the specific resource.
     *
     * @param  request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * @OA\Patch(
     * path="/api/notes/update/{note_id}",
     * tags={"Notes"},
     * summary="Update note by ID",
     * description="Modified note data by ID",
     *  @OA\Parameter(
     *      description="ID of notes",
     *      in="path",
     *      name="note_id",
     *      required=true,
     *      example="da9081e0-b20b-4228-a605-4afa34b8e963",
     *      @OA\Schema(
     *          type="string",
     *          format="uuid"
     *      ),
     *  ),
     *  @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "title":"example title",
     *                     "description":"example description"
     *                }
     *          )
     *      )
     *  ),
     *      @OA\Response(
     *          response=200,
     *          description="Update notes success",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean"),
     *              @OA\Property(
     *                  property="data",
     *                  @OA\Property(property="id", type="string"),
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="description", type="string"),
     *                  @OA\Property(property="deleted_at", type="string"),
     *                  @OA\Property(property="created_at", type="string"),
     *                  @OA\Property(property="updated_at", type="string")
     *              ),
     *              @OA\Property(property="message", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Error Validation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", default="false"),
     *              @OA\Property(property="message", type="string", default="Error validation"),
     *              @OA\Property(
     *                  property="data", 
     *                  type="object",
     *                  @OA\Property(property="title", type="array", @OA\Items()),
     *                  @OA\Property(property="description", type="array", @OA\Items())
     *              )
     *          )
     *      )
     * )
     */
    public function updateById(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'description' => 'required',
        ]);
        $input = $request->all();

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $payload = [
            "title" => $input['title'],
            "description" => $input['description'],
        ];

        Notes::whereId($id)->update($payload);
        $update = Notes::where('id', $id)->first();

        return $this->sendResponse($update, "Update notes success");
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * @OA\Delete(
     * path="/api/notes/delete/{note_id}",
     * tags={"Notes"},
     * summary="Get note by ID",
     * description="Display specific note by ID",
     *  @OA\Parameter(
     *      description="ID of notes",
     *      in="path",
     *      name="note_id",
     *      required=true,
     *      example="da9081e0-b20b-4228-a605-4afa34b8e963",
     *      @OA\Schema(
     *          type="string",
     *          format="uuid"
     *      ),
     *  ),
     *      @OA\Response(
     *          response=200,
     *          description="Delete notes success",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean"),
     *              @OA\Property(property="message", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", default="false"),
     *              @OA\Property(property="message", type="string", default="Not Found")
     *          )
     *      )
     * )
     */
    public function deleteById($id) {
        $notes = Notes::whereId($id)->forceDelete();

        if (!$notes) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete notes success');
    }
}
