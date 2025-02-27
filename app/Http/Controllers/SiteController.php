<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Display the about page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Display the security doors page.
     *
     * @return \Illuminate\View\View
     */
    public function securityDoors()
    {
        return view('pages.products.security-doors');
    }

    /**
     * Display the interior doors page.
     *
     * @return \Illuminate\View\View
     */
    public function interiorDoors()
    {
        return view('pages.products.interior-doors');
    }

    /**
     * Display the aluminum solutions page.
     *
     * @return \Illuminate\View\View
     */
    public function aluminumSolutions()
    {
        return view('pages.products.aluminum-solutions');
    }

    /**
     * Display the blog articles page.
     *
     * @return \Illuminate\View\View
     */
    public function blog()
    {
        return view('pages.articles.blog');
    }

    /**
     * Display the news articles page.
     *
     * @return \Illuminate\View\View
     */
    public function news()
    {
        return view('pages.articles.news');
    }

    /**
     * Display the installation guides page.
     *
     * @return \Illuminate\View\View
     */
    public function guides()
    {
        return view('pages.articles.guides');
    }

    /**
     * Display the catalogue page.
     *
     * @return \Illuminate\View\View
     */
    public function catalogue()
    {
        return view('pages.catalogue');
    }

    /**
     * Display the support page.
     *
     * @return \Illuminate\View\View
     */
    public function support()
    {
        return view('pages.support');
    }

    /**
     * Display the careers page.
     *
     * @return \Illuminate\View\View
     */
    public function careers()
    {
        return view('pages.careers');
    }

    /**
     * Display the showroom page.
     *
     * @return \Illuminate\View\View
     */
    public function showroom()
    {
        return view('pages.showroom');
    }

    /**
     * Display the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Store a new contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        // Process the contact form submission
        // You can add code to send emails, store in database, etc.

        return redirect()->route('contact')->with('success', 'Thank you for your message. We will contact you shortly.');
    }
}
