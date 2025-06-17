<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SocialLinkController extends Controller
{
    /**
     * Display social links for a member
     */
    public function index(Member $member): JsonResponse
    {
        $socialLinks = $member->socialLinks()->get();

        return response()->json([
            'success' => true,
            'data' => $socialLinks
        ]);
    }

    /**
     * Store a new social link
     */
    public function store(Request $request, Member $member): JsonResponse
    {
        $request->validate([
            'platform' => 'required|in:facebook,twitter,instagram,linkedin,tiktok,youtube',
            'url' => 'required|url|max:255'
        ]);

        // Check if member already has this platform
        $existing = $member->socialLinks()
                          ->where('platform', $request->platform)
                          ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Member already has a ' . $request->platform . ' account linked'
            ], 400);
        }

        $socialLink = $member->socialLinks()->create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Social link added successfully',
            'data' => $socialLink
        ], 201);
    }

    /**
     * Display the specified social link
     */
    public function show(SocialLink $socialLink): JsonResponse
    {
        $socialLink->load('member');

        return response()->json([
            'success' => true,
            'data' => $socialLink
        ]);
    }

    /**
     * Update the specified social link
     */
    public function update(Request $request, SocialLink $socialLink): JsonResponse
    {
        $request->validate([
            'platform' => 'sometimes|required|in:facebook,twitter,instagram,linkedin,tiktok,youtube',
            'url' => 'sometimes|required|url|max:255'
        ]);

        // If platform is being changed, check for duplicates
        if ($request->has('platform') && $request->platform !== $socialLink->platform) {
            $existing = $socialLink->member->socialLinks()
                                  ->where('platform', $request->platform)
                                  ->where('id', '!=', $socialLink->id)
                                  ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Member already has a ' . $request->platform . ' account linked'
                ], 400);
            }
        }

        $socialLink->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Social link updated successfully',
            'data' => $socialLink
        ]);
    }

    /**
     * Remove the specified social link
     */
    public function destroy(SocialLink $socialLink): JsonResponse
    {
        $socialLink->delete();

        return response()->json([
            'success' => true,
            'message' => 'Social link deleted successfully'
        ]);
    }
}