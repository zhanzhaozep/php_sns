<?php
class TweetController extends Controller
{
    public $auth_user;
    public function __construct()
    {
        if (Session::has("auth_user")) {
            $this->auth_user = Session::get("auth_user");
        } else {
            Route::redirect('../login/');
        }
    }

    public function index()
    {
        $tweet = new Tweet();
        $tweets = $tweet->get();
        $like = new Like();
        $like_counts = $like->counts();
        $user_likes = $like->valuesByUser($this->auth_user);

        $data = [
            'tweets' => $tweets,
            'like_counts' => $like_counts,
            'user_likes' => $user_likes,
            'user' => $this->auth_user,
        ];
        View::render('tweet/index', $data);
    }

    public function add()
    {
        $tweet = new Tweet();
        $post = $_POST;
        $post['user_id'] = $this->auth_user['id'];
        $tweet->validate($post);
        if (!$tweet->errors) {
            $tweet->save($post);
        }
        Route::redirect('./');
    }

    public function like()
    {
        $like = new Like();
        if ($value = $like->has($_POST['tweet_id'], $_POST['user_id'])) {
            $like->delete($value['id']);
        } else {
            $like->save($_POST);
        }
        Route::redirect('./');
    }
}
