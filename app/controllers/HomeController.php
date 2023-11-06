<?php

class HomeController extends Controller
{
public function about()
{
return 'Hello';
}
public function search(Request $request)
{
return $request->keyword;
}
public function update(Request $request, $id)
{
return $id;
}
}