<?php

namespace App\Http\Controllers;

use App\DTOs\WishlistDTO;
use App\DTOs\WishlistCountryDTO;
use App\Http\Requests\StoreWishlistRequest;
use App\Http\Resources\WishlistResource;
use App\Models\Country;
use App\Models\Wishlist;
use App\Services\WishlistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class WishlistController extends Controller
{
    /**
     * @param WishlistService $wishlistService
     */
    public function __construct(
        protected WishlistService $wishlistService
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
     * todo refactor to inject the country repository
     *
     * @param StoreWishlistRequest $request
     * @return JsonResponse
     */
    public function store(StoreWishlistRequest $request): JsonResponse
    {
        $wishlistDTO = new WishlistDTO(
            user: $request->user(),
            name: $request->input('name'),
            notes: $request->input('notes'),
            countries: array_map(
                function ($data) {
                    return new WishlistCountryDTO(
                        country: Country::find($data['country_id']),
                        startDate: $data['start_date'],
                        endDate: $data['end_date'],
                        notes: $data['notes'] ?? null
                    );
                },
                $request->input('countries', [])
            )
        );

        $wishlist = $this->wishlistService->createWishlist($wishlistDTO);

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
     * todo consider refactoring to a mapper here
     *
     * @param StoreWishlistRequest $request
     * @param Wishlist $wishlist
     * @return JsonResponse
     */
    public function update(StoreWishlistRequest $request, Wishlist $wishlist): JsonResponse
    {
        $wishlistDTO = new WishlistDTO(
            user: $request->user(),
            name: $request->input('name'),
            notes: $request->input('notes'),
            countries: array_map(
                function ($data) {
                    return new WishlistCountryDTO(
                        country: Country::find($data['country_id']),
                        startDate: $data['start_date'],
                        endDate: $data['end_date'],
                        notes: $data['notes'] ?? null
                    );
                },
                $request->input('countries', [])
            )
        );

        $wishlist = $this->wishlistService->updateWishlist($wishlist, $wishlistDTO);

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
