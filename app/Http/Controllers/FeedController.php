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
        if ($request->routeIs('customer.*')) {
            return view('feeds.customer_index');
        }

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
        $route = request()->routeIs('staff.*') ? 'staff.products.index' : 'admin.products.index';
        return redirect()->route($route)->with('success', 'Product created successfully.');
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
        $route = request()->routeIs('staff.*') ? 'staff.products.index' : 'admin.products.index';
        return redirect()->route($route)->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $this->feedService->deleteFeed($id);
        $route = request()->routeIs('staff.*') ? 'staff.products.index' : 'admin.products.index';
        return redirect()->route($route)->with('success', 'Product deleted successfully.');
    }

    public function toggleDisplay($id)
    {
        $this->feedService->toggleDisplay($id);
        return back()->with('success', 'Feed display status updated.');
    }
}
