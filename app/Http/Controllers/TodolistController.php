<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    private TodolistService $todoListService;

    public function __construct(TodolistService $todolistService)
    {
        $this->todoListService = $todolistService;
    }

    public function todoList(Request $request)
    {
        $todolist = $this->todoListService->getTodolist();
        return response()->view('todolist.todolist', [
            'title' => 'Todolist',
            'todolist' => $todolist
        ]);
    }

    public function addTodo(Request $request)
    {
        $todo = $request->input('todo');

        if (empty($todo)) {
            $todolist = $this->todoListService->getTodolist();
            return response()->view('todolist.todolist', [
                'title' => 'Todolist',
                'todolist' => $todolist,
                'error' => 'Todo is required'
            ]);
        }

        $this->todoListService->saveTodo(uniqid(), $todo);

        return redirect('/todolist');
    }

    public function removeTodo(Request $request, string $todoId)
    {
        $this->todoListService->removeTodo($todoId);
        return redirect('/todolist');
    }
}
