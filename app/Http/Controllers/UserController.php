<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

use App\Http\Requests\UpdateUserRequest;


class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return response()->json($user);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'User not found',
            ], 404);
        }

        return response()->json($user);
    }

    // TODO handle image upload
    public function update(UpdateUserRequest $request, $id)
    {
        function getBytesFromHexString($hexdata)
        {
        for($count = 0; $count < strlen($hexdata); $count+=2)
            $bytes[] = chr(hexdec(substr($hexdata, $count, 2)));

        return implode($bytes);
        }

        function getImageMimeType($imagedata)
        {
        $imagemimetypes = array(
            "jpeg" => "FFD8",
            "png" => "89504E470D0A1A0A",
            "gif" => "474946",
        );

        foreach ($imagemimetypes as $mime => $hexbytes)
        {
            $bytes = getBytesFromHexString($hexbytes);
            if (substr($imagedata, 0, strlen($bytes)) == $bytes)
            return $mime;
        }

        return NULL;
        }

        $validated = $request->validated();

        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'User not found'
            ], 404);
        }

        $temp = Arr::except($validated, ['image']);

        $user->update($temp);

        if ($request->has('image')) {
            $image = base64_decode($request->image);

            $mime = getImageMimeType($image);
            $allowedExtensions = ['jpeg', 'png', 'gif'];

            if (!in_array($mime, $allowedExtensions)) {
                return response()->json(['error' => true, 'message' => 'Invalid file type'], 400);
            }

            // Generate a unique name for the file
            $file_name = Str::random(15) . ".$mime";

            // Move the uploaded file to the public directory
            Storage::disk('public')->put($file_name, $image);

            // Save the file name to the user's profile
            $user['image'] = $file_name;
        }

        try {
            $user->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
        ], 201);
    }

    public function store(RegisterUserRequest $request) {
        $validated = $request->validated();

        $user = new User($validated);

        try {
            $user->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function destroy($id)
    {
        // TODO delete related records in patients table
        //User::delete($id);

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ], 204)->withCookie(cookie('token', '', 1, null, null, false, true));
    }
}
?>