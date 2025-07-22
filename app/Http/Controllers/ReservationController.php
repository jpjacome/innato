<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    // Show the reservation form
    public function showForm()
    {
        return view('reservation');
    }

    // Handle reservation form submission
    public function store(Request $request)
    {
        // If AJAX, return JSON responses
        if ($request->expectsJson() || $request->ajax()) {
            try {
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'destination_id' => 'required|exists:destinations,id',
                    'people_count' => 'required|integer|min:1',
                    'date' => 'required|date',
                    'phone_number' => 'required|string|max:30',
                ]);
                Reservation::create($validated);
                return response()->json(['success' => true, 'message' => 'Reservation sent!']);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json(['success' => false, 'errors' => $e->errors()], 422);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Server error. Please try again.'], 500);
            }
        }
        // Fallback to normal behavior
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'destination_id' => 'required|exists:destinations,id',
            'people_count' => 'required|integer|min:1',
            'date' => 'required|date',
            'phone_number' => 'required|string|max:30',
        ]);
        Reservation::create($validated);
        return redirect()->back()->with('success', 'Reservation submitted successfully!');
    }
    // Delete a reservation (admin AJAX)
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return response()->json(['success' => true]);
    }
}
