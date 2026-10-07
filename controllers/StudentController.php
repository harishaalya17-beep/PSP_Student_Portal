<?php

require_once __DIR__ . '/../models/Student.php';

class StudentController
{
    public function index()
    {
        return Student::getAll();
    }

    public function show($id)
    {
        return Student::getById($id);
    }
    public function create($name, $ic, $program, $marks, $password)
    {
    return Student::create(
        $name,
        $ic,
        $program,
        $marks,
        $password
    );
    }
    public function update($id, $name, $ic, $program, $marks)
    {
    return Student::update(
        $id,
        $name,
        $ic,
        $program,
        $marks
    );
    }
    public function delete($id)
    {
    return Student::delete($id);
    }
}
?>