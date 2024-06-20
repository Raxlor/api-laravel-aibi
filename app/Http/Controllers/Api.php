<?php 
/**
 * @OA\Get(
 *     path="/api/users",
 *     tags={"Users"},
 *     summary="Get all users",
 *     description="Returns a list of all users",
 *     @OA\Response(response=200, description="Successful operation"),
 *     @OA\Response(response=404, description="Users not found")
 * )
 */
