<?php
// app/Swagger/Schemas.php

namespace App\Swagger;

class Schemas
{

    /**
     * @OA\Schema(
     *     schema="JobListing",
     *     type="object",
     *     title="Job Listing",
     *     required={"title", "job_description", "status", "closing_date", "category_id", "tag_id"},
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         format="int64"
     *     ),
     *     @OA\Property(
     *         property="title",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="job_description",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="status",
     *         type="string",
     *         enum={"open", "preview", "closed"}
     *     ),
     *     @OA\Property(
     *         property="closing_date",
     *         type="string",
     *         format="date"
     *     ),
     *     @OA\Property(
     *         property="category_id",
     *         type="integer"
     *     ),
     *     @OA\Property(
     *         property="category",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="tag",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="location",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="salary_range",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="assessment_id",
     *         type="integer"
     *     ),
     * )
     */
    public function JobListing()
    {
    }






    /**
     * @OA\Schema(
     *     schema="Assessment",
     *     type="object",
     *     title="Assessment",
     *     required={"title", "description", "pass_mark", "questions"},
     *     @OA\Property(
     *         property="title",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="pass_mark",
     *         type="string",
     *         description="The pass mark percentage"
     *     ),
     *     @OA\Property(
     *         property="total_allocated_marks",
     *         type="integer",
     *         format="int32"
     *     ),
     *     @OA\Property(
     *         property="total_time_required_in_minutes",
     *         type="integer",
     *         format="int32"
     *     ),
     *     @OA\Property(
     *         property="computed_pass_mark_in_marks",
     *         type="number",
     *         format="float"
     *     ),
     *     @OA\Property(
     *         property="category",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="questions",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Question")
     *     ),
     * )
     *
     * @OA\Schema(
     *     schema="Question",
     *     type="object",
     *     title="Question",
     *     required={"question", "allocated_marks"},
     *     @OA\Property(
     *         property="question",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="allocated_marks",
     *         type="integer",
     *         format="int32"
     *     ),
     *     @OA\Property(
     *         property="multiple_choices",
     *         type="array",
     *         @OA\Items(type="string")
     *     ),
     *     @OA\Property(
     *         property="correct_answer",
     *         type="string"
     *     ),
     * )
     */
    public function Assessment()
    {
    }

    /**
     * @OA\Schema(
     *     schema="Interview",
     *     type="object",
     *     title="Interview",
     *     properties={
     *         @OA\Property(property="id", type="integer", example=1),
     *         @OA\Property(property="requirements", type="string", example="Bring your resume"),
     *         @OA\Property(property="title", type="string", example="Technical Interview"),
     *         @OA\Property(property="interview_date", type="string", format="date", example="2024-08-01"),
     *         @OA\Property(property="interview_time", type="string", format="time", example="14:00"),
     *         @OA\Property(property="job_title", type="string", example="Software Developer"),
     *         @OA\Property(property="location_name", type="string", example="New York Office"),
     *         @OA\Property(property="created_at", type="string", format="date-time", example="2024-07-01T12:00:00Z"),
     *         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-15T12:00:00Z"),
     *     }
     * )
     */
    public function Interview()
    {
    }
}
