<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Receipt;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // Добавление рецепта
    public function postReceiptAdd(Request $request)
    {
        // Если использовать авторизацию
        // $user = Auth::user(); // Так выполнено в Laravel
        $user = User::findOrFail($request->userId);

        $photo = '';
        // Если файл фотографии загружен
        if ($request->hasFile('photo')) {
            // Изменение имени файла для сохранения
            $md5 = md5($request->file('photo')->getClientOriginalName() . Carbon::now());
            $pathToMove = 'photos/receipts';
            $photo = $md5 . '.' . $request->file('photo')->getClientOriginalExtension();
            $path = $request->file('photo')->move($pathToMove, $photo);
        }

        $receipt = $user->receipts()->create([
            'title' => $request->title,
            'text' => $request->text,
            'photo' => $photo
        ]);
        return response()->json(['receipt' => $receipt]);
    }

    // Редактирование рецепта
    public function postReceiptEdit(Request $request, $id)
    {
        $receipt = Receipt::findOrFail($id);
        $photo = $receipt->photo;
        // Если загружен файл фотографии
        if ($request->hasFile('photo')) {
            $oldName = $receipt->photo;
            // Удаление предыдущей фотографии
            if($oldName !== '') {
                unlink(substr($oldName, 1));
            }
            $md5 = md5($request->file('photo')->getClientOriginalName() . Carbon::now());
            $pathToMove = 'photos/receipts';
            $photo = $md5 . '.' . $request->file('photo')->getClientOriginalExtension();
            $path = $request->file('photo')->move($pathToMove, $photo);
        }
        $receipt->update([
            'title' => $request->title,
            'text' => $request->text,
            'photo' => $photo
        ]);
        return response()->json(['receipt' => $receipt]);
    }

    // Удаление рецепта
    public function deleteReceiptRemove($id)
    {
        $receipt = Receipt::findOrFail($id);

        // Удаление файла фотографии
        if ($receipt->photo !== '') {
            unlink(substr($receipt->photo, 1));
        }
        $receipt->delete();
        return response()->json(['deleted' => true]);
    }
}
