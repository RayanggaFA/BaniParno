<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\Member;
use App\Models\MemberHistories;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function getStats(): JsonResponse
    {
        $stats = [
            'total_families' => Family::count(),
            'total_members' => Member::count(),
            'active_members' => Member::where('status', 'active')->count(),
            'deceased_members' => Member::where('status', 'deceased')->count(),
            'male_members' => Member::where('gender', 'male')->count(),
            'female_members' => Member::where('gender', 'female')->count(),
            'recent_additions' => Member::where('created_at', '>=', now()->subDays(30))->count(),
            'average_age' => Member::where('status', 'active')->avg('birth_date') ? 
                           Carbon::now()->diffInYears(
                               Carbon::parse(Member::where('status', 'active')->avg('birth_date'))
                           ) : 0
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get recent members
     */
    public function getRecentMembers(): JsonResponse
    {
        $recentMembers = Member::with(['family'])
                              ->orderBy('created_at', 'desc')
                              ->limit(10)
                              ->get();

        return response()->json([
            'success' => true,
            'data' => $recentMembers
        ]);
    }

    /**
     * Get statistics by generation
     */
    public function getByGeneration(): JsonResponse
    {
        $generationStats = Family::withCount('activeMembers')
                                ->orderBy('generation')
                                ->get()
                                ->map(function ($family) {
                                    return [
                                        'generation' => $family->generation,
                                        'family_name' => $family->name,
                                        'branch' => $family->branch,
                                        'member_count' => $family->active_members_count,
                                        'color' => $family->color
                                    ];
                                });

        return response()->json([
            'success' => true,
            'data' => $generationStats
        ]);
    }

    /**
     * Get statistics by location
     */
    public function getByLocation(): JsonResponse
    {
        $locationStats = Member::selectRaw('domicile_province, domicile_city, COUNT(*) as member_count')
                              ->where('status', 'active')
                              ->groupBy('domicile_province', 'domicile_city')
                              ->orderBy('member_count', 'desc')
                              ->get()
                              ->map(function ($item) {
                                  return [
                                      'province' => $item->domicile_province,
                                      'city' => $item->domicile_city,
                                      'count' => $item->member_count,
                                      'location' => $item->domicile_city . ', ' . $item->domicile_province
                                  ];
                              });

        // Group by province
        $provinceStats = $locationStats->groupBy('province')
                                     ->map(function ($cities, $province) {
                                         return [
                                             'province' => $province,
                                             'total_members' => $cities->sum('count'),
                                             'cities' => $cities->values()
                                         ];
                                     })
                                     ->values()
                                     ->sortByDesc('total_members');

        return response()->json([
            'success' => true,
            'data' => [
                'by_city' => $locationStats,
                'by_province' => $provinceStats
            ]
        ]);
    }

    /**
     * Get statistics by age group
     */
    public function getByAgeGroup(): JsonResponse
    {
        $members = Member::where('status', 'active')
                        ->whereNotNull('birth_date')
                        ->get();

        $ageGroups = [
            '0-10' => 0,
            '11-20' => 0,
            '21-30' => 0,
            '31-40' => 0,
            '41-50' => 0,
            '51-60' => 0,
            '61-70' => 0,
            '71+' => 0
        ];

        foreach ($members as $member) {
            $age = $member->age;
            
            if ($age <= 10) {
                $ageGroups['0-10']++;
            } elseif ($age <= 20) {
                $ageGroups['11-20']++;
            } elseif ($age <= 30) {
                $ageGroups['21-30']++;
            } elseif ($age <= 40) {
                $ageGroups['31-40']++;
            } elseif ($age <= 50) {
                $ageGroups['41-50']++;
            } elseif ($age <= 60) {
                $ageGroups['51-60']++;
            } elseif ($age <= 70) {
                $ageGroups['61-70']++;
            } else {
                $ageGroups['71+']++;
            }
        }

        $ageGroupsFormatted = collect($ageGroups)->map(function ($count, $group) {
            return [
                'age_group' => $group,
                'count' => $count,
                'percentage' => $count > 0 ? round(($count / Member::where('status', 'active')->count()) * 100, 1) : 0
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => $ageGroupsFormatted
        ]);
    }

    /**
     * Get recent activities/changes
     */
    public function getRecentActivities(): JsonResponse
    {
        $activities = MemberHistory::with(['member'])
                                  ->orderBy('created_at', 'desc')
                                  ->limit(20)
                                  ->get()
                                  ->map(function ($history) {
                                      return [
                                          'id' => $history->id,
                                          'member_name' => $history->member->name,
                                          'field_changed' => $history->formatted_field,
                                          'old_value' => $history->old_value,
                                          'new_value' => $history->new_value,
                                          'changed_by' => $history->changed_by,
                                          'reason' => $history->reason,
                                          'date' => $history->created_at->format('Y-m-d H:i:s'),
                                          'date_human' => $history->created_at->diffForHumans()
                                      ];
                                  });

        return response()->json([
            'success' => true,
            'data' => $activities
        ]);
    }

    /**
     * Get family growth over time
     */
    public function getFamilyGrowth(): JsonResponse
    {
        $growth = Member::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                       ->groupBy('month')
                       ->orderBy('month')
                       ->get()
                       ->map(function ($item) {
                           return [
                               'month' => $item->month,
                               'count' => $item->count,
                               'formatted_month' => Carbon::createFromFormat('Y-m', $item->month)->format('M Y')
                           ];
                       });

        return response()->json([
            'success' => true,
            'data' => $growth
        ]);
    }
}