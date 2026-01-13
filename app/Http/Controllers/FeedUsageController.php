<?php

namespace App\Http\Controllers;

use App\Services\FeedUsageService;
use App\Services\FeedService;
use App\Services\ChickRearingService;
use App\Http\Requests\StoreFeedUsageRequest;
use Illuminate\Http\Request;
use Exception;

class FeedUsageController extends Controller
{
    protected $feedUsageService;
    protected $feedService;
    protected $chickRearingService;

    public function __construct(
        FeedUsageService $feedUsageService,
        FeedService $feedService,
        ChickRearingService $chickRearingService
    ) {
        $this->feedUsageService = $feedUsageService;
        $this->feedService = $feedService;
        $this->chickRearingService = $chickRearingService;
    }

    public function index(Request $request)
    {
        $feedUsages = $this->feedUsageService->getAllFeedUsages($request->all());
        $feeds = $this->feedService->getAllFeeds([], 1000); // For filter
        $chickRearings = $this->chickRearingService->getAllChickRearings([], 1000); // For filter

        return view('feed_usages.index', compact('feedUsages', 'feeds', 'chickRearings'));
    }

    public function create()
    {
        $feeds = $this->feedService->getAllFeeds([], 1000);
        $chickRearings = $this->chickRearingService->getAllChickRearings([], 1000);
        
        return view('feed_usages.create', compact('feeds', 'chickRearings'));
    }

    public function store(StoreFeedUsageRequest $request)
    {
        try {
            $this->feedUsageService->recordUsage($request->validated());
            return redirect()->route('staff.feed-usages.index')->with('success', 'Feed usage recorded successfully.');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
