<?php

namespace App\Http\Controllers;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Author;

class AuthorController extends Controller
{
    use ApiResponser;

    /**
     * Return the list of authors
     * @return Illuminate\Http\Response
     */
    public function index() 
    {
        $authors = Author::all();

        return $this->successResponse($authors);
    }

    /**
     * Create one new author
     * @return Illuminate\Http\Response
     */
    public function store(Request $request) 
    {
        $rules = [
            'name'     => 'required|max:255',
            'gender'   => 'required|max:255|in:male,female',
            'country'  => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $author = Author::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * Obtains and show one author
     * @return Illuminate\Http\Response
     */
    public function show($author) 
    {
        $author = Author::findOrFail($author);

        return $this->successResponse($author);
    }

    /**
     * Updates an existing author
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $author) 
    {
        $rules = [
            'name'     => 'max:255',
            'gender'   => 'max:255|in:male,female',
            'country'  => 'max:255',
        ];

        $this->validate($request, $rules);

        $author = Author::findOrFail($author);

        $author->fill($request->all());

        if($author->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $author->save();

        return $this->successResponse($author);
    }

    /**
     * Removes an author
     * @return Illuminate\Http\Response
     */
    public function destroy($author) 
    {
        $author = Author::findOrFail($author);

        $author->delete();

        return $this->successResponse($author);
    }

    /*
    * Obtain the full list of author form the author service
    * @return string
    */
    public function obtainAuthors()
    {
        return $this->performRequest('GET', '/authors');
    }

    /*
    * Create new author using the author service
    * @return string
    */
    public function createAuthors($data)
    {
        return $this->performRequest('POST', '/authors', $data);
    }

    /*
    * Returns single author using the author service
    * @return string
    */
    public function obtainAuthor($author)
    {
        return $this->performRequest('POST', "/authors/{$author}");
    }

    /*
    * Updates single author using the author service
    * @return string
    */
    public function editAuthor($data, $author)
    {
        return $this->performRequest('PUT', "/authors/{$author}", $data);
    }

    /*
    * Removes single author using the author service
    * @return string
    */
    public function deleteAuthor($author)
    {
        return $this->performRequest('DELETE', "/authors/{$author}");
    }
}
