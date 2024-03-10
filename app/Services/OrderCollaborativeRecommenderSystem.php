<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class OrderCollaborativeRecommenderSystem
{
    public function suggestMoviesFor($order, $userId)
    {
        $usersWhoLikedIt = $this->getUsersWhoLiked($order, $userId);
        $suggestedMovies = $this->getSuggestedMovies($usersWhoLikedIt, $order);

        return $suggestedMovies;
    }

    private function getUsersWhoLiked($order, $userId)
    {
        $userObjects = DB::table('carts')
            ->select('user_id', 'product_id')
            ->where('product_id', $order)
            ->whereNotNull('order_id')
            ->where('user_id', '<>', $userId)
            ->get();

        return $userObjects->pluck('user_id')->toArray();
    }

    private function getSuggestedMovies($users, $id)
    {
        $ratingObjects = DB::table('carts')
            ->whereIn('user_id', $users)
            ->select('product_id', 'user_id')
            ->get();

        $movieScores = [];

        foreach ($ratingObjects as $ratingObject) {
            $movieScores[$ratingObject->product_id] = ($movieScores[$ratingObject->product_id] ?? 0) + 1;
        }
        arsort($movieScores);
        unset($movieScores[$id]);

        return array_slice($movieScores, 0, 10, true);
    }
}
