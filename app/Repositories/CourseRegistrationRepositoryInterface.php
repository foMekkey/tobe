<?php

namespace App\Repositories;

interface CourseRegistrationRepositoryInterface
{
    public function all();
    public function find($id, $with = []);
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function approve($id);
    public function reject($id);
    public function getPending();
    public function getByUser($userId);
    public function getByCourse($courseId);
    public function getByCohort($cohortId);
    public function getByUserAndCourse($userId, $courseId);
}