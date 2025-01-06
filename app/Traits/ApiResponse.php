<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    /**
     * Return a success response.
     *
     * @param mixed|null $data Optional data to include in the response.
     * @param string|null $message Optional success message.
     * @param int $statusCode HTTP status code (default: 200).
     * @param array $headers Optional headers.
     *
     * @return JsonResponse Success JSON response.
     */
    public function successResponse(
        mixed $data = null,
        ?string $message = null,
        int $statusCode = Response::HTTP_OK,
        array $headers = []
    ): JsonResponse {
        return response()->json([
            'status' => 'success',
            'message' => __($message ?? 'messages.success'),
            'data' => $data,
        ], $statusCode, $headers);
    }

    /**
     * Return an error response.
     *
     * @param string $message Error message key for localization.
     * @param int $statusCode HTTP status code (default: 400).
     * @param mixed|null $errors Optional detailed errors.
     * @param array $headers Optional headers.
     *
     * @return JsonResponse Error JSON response.
     */
    public function errorResponse(
        string $message,
        int $statusCode = Response::HTTP_BAD_REQUEST,
        mixed $errors = null,
        array $headers = []
    ): JsonResponse {
        return response()->json([
            'status' => 'error',
            'message' => __($message),
            'errors' => $errors,
        ], $statusCode, $headers);
    }

    /**
     * Return a validation error response.
     *
     * @param ValidationException $exception Validation exception instance.
     *
     * @return JsonResponse Validation error JSON response.
     */
    public function validationErrorResponse(ValidationException $exception): JsonResponse
    {
        $errors = collect($exception->errors())->map(function ($messages, $field) {
            return [
                'field' => $field,
                'message' => __($messages[0]),
            ];
        })->values();

        return $this->errorResponse(
            'validation.failed',
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $errors
        );
    }

    /**
     * Return a created response.
     *
     * @param mixed|null $data Optional data to include in the response.
     * @param string|null $message Success message key for localization.
     *
     * @return JsonResponse Created JSON response.
     */
    public function createdResponse(mixed $data = null, ?string $message = 'messages.created'): JsonResponse
    {
        return $this->successResponse($data, $message, Response::HTTP_CREATED);
    }

    /**
     * Return a no content response.
     *
     * @param string|null $message Success message key for localization.
     *
     * @return JsonResponse No content JSON response.
     */
    public function noContentResponse(?string $message = 'messages.no_content'): JsonResponse
    {
        return $this->successResponse(null, $message, Response::HTTP_NO_CONTENT);
    }

    /**
     * Return a not found error response.
     *
     * @param string|null $message Error message key for localization.
     * @param mixed|null $details Optional error details.
     *
     * @return JsonResponse Not found JSON response.
     */
    public function notFoundResponse(?string $message = 'messages.not_found', mixed $details = null): JsonResponse
    {
        return $this->errorResponse($message, Response::HTTP_NOT_FOUND, $details);
    }

    /**
     * Return an unauthorized error response.
     *
     * @param string|null $message Error message key for localization.
     *
     * @return JsonResponse Unauthorized JSON response.
     */
    public function unauthorizedResponse(?string $message = 'messages.unauthorized'): JsonResponse
    {
        return $this->errorResponse($message, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Return a forbidden error response.
     *
     * @param string|null $message Error message key for localization.
     *
     * @return JsonResponse Forbidden JSON response.
     */
    public function forbiddenResponse(?string $message = 'messages.forbidden'): JsonResponse
    {
        return $this->errorResponse($message, Response::HTTP_FORBIDDEN);
    }

    /**
     * Return a server error response.
     *
     * @param string|null $message Error message key for localization.
     *
     * @return JsonResponse Server error JSON response.
     */
    public function serverErrorResponse(?string $message = 'messages.server_error'): JsonResponse
    {
        return $this->errorResponse($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
