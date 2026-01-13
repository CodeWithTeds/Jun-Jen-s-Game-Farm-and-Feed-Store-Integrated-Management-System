<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedRequest;
use App\Http\Requests\UpdateFeedRequest;
use App\Services\FeedService;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    protected $feedService;

    public function __construct(FeedService $feedService)
    {
        $this->feedService = $feedService;
    }

    public function index(Request $request)
    {
        $feeds = $this->feedService->getAllFeeds($request->all());
        return view('feeds.index', compact('feeds'));
    }

    public function create()
    {
        return view('feeds.create');
    }

    public function store(StoreFeedRequest $request)
    {
        $this->feedService->createFeed($request->validated());
        return redirect()->route('staff.feeds.index')->with('success', 'Feed created successfully.');
    }

    public function show($id)
    {
        $feed = $this->feedService->getFeedById($id);
        return view('feeds.show', compact('feed'));
    }

    public function edit($id)
    {
        $feed = $this->feedService->getFeedById($id);
        return view('feeds.edit', compact('feed'));
    }

    public function update(UpdateFeedRequest $request, $id)
    {
        $this->feedService->updateFeed($id, $request->validated());
        return redirect()->route('staff.feeds.index')->with('success', 'Feed updated successfully.');
    }

    public function destroy($id)
    {
        $this->feedService->deleteFeed($id);
        return redirect()->route('staff.feeds.index')->with('success', 'Feed deleted successfully.');
    }
}
