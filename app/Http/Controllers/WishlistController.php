<?php

namespace App\Http\Controllers;

use App\DTOs\WishlistDTO;
use App\Http\Requests\StoreWishlistRequest;
use App\Http\Resources\WishlistResource;
use App\Models\Wishlist;
use App\Services\WishlistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class WishlistController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct(
        protected WishlistService $wishlistService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => WishlistResource::collection(
                $this->wishlistService->getAllWishlists()
            )
        ]);
    }

    /**
     * Store a new wishlist.
     */
    public function store(StoreWishlistRequest $request): JsonResponse
    {
        $wishlist = $this->wishlistService->createWishlist(
            WishlistDTO::fromRequest($request)
        );

        return response()->json([
            'message' => 'Wishlist created successfully.',
            'data' => WishlistResource::make($wishlist)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist): JsonResponse
    {
        $wishlist->load('countries');

        return response()->json([
            'data' => WishlistResource::make($wishlist)
        ]);
    }

    /**
     * Update an existing wishlist.
     */
    public function update(StoreWishlistRequest $request, Wishlist $wishlist): JsonResponse
    {
        $wishlist = $this->wishlistService->updateWishlist(
            $wishlist,
            WishlistDTO::fromRequest($request)
        );

        return response()->json([
            'message' => 'Wishlist updated successfully.',
            'data' => WishlistResource::make($wishlist)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wishlist $wishlist): Response
    {
        $this->wishlistService->deleteWishlist($wishlist);
        return response()->noContent();
    }
}
