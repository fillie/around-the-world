<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWishlistRequest;
use App\Http\Resources\WishlistResource;
use App\Models\Wishlist;
use App\Services\WishlistService;
use App\Mappers\WishlistMapper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class WishlistController extends Controller
{
    /**
     * @param WishlistService $wishlistService
     * @param WishlistMapper $wishlistMapper
     */
    public function __construct(
        protected WishlistService $wishlistService,
        protected WishlistMapper $wishlistMapper
    ) {}

    /**
     * @return JsonResponse
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
     * @param StoreWishlistRequest $request
     * @return JsonResponse
     */
    public function store(StoreWishlistRequest $request): JsonResponse
    {
        $wishlist = $this->wishlistService->createWishlist(
            $this->wishlistMapper->mapRequestToWishlistDTO($request)
        );

        return response()->json([
            'message' => 'Wishlist created successfully.',
            'data' => WishlistResource::make($wishlist)
        ], 201);
    }

    /**
     * @param Wishlist $wishlist
     * @return JsonResponse
     */
    public function show(Wishlist $wishlist): JsonResponse
    {
        $wishlist->load('countries');

        return response()->json([
            'data' => WishlistResource::make($wishlist)
        ]);
    }

    /**
     * @param StoreWishlistRequest $request
     * @param Wishlist $wishlist
     * @return JsonResponse
     */
    public function update(StoreWishlistRequest $request, Wishlist $wishlist): JsonResponse
    {
        $wishlist = $this->wishlistService->updateWishlist($wishlist,
            $this->wishlistMapper->mapRequestToWishlistDTO($request)
        );

        return response()->json([
            'message' => 'Wishlist updated successfully.',
            'data' => WishlistResource::make($wishlist)
        ]);
    }

    /**
     * @param Wishlist $wishlist
     * @return Response
     */
    public function destroy(Wishlist $wishlist): Response
    {
        $this->wishlistService->deleteWishlist($wishlist);
        return response()->noContent();
    }
}
