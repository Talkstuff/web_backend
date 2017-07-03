<?php

function transform($data, $transformer){
    if(!$data) return null;

    if($data instanceof \Illuminate\Support\Collection || is_array($data)){
        return fractal()->collection($data, $transformer);
    }

    return fractal()->item($data, $transformer);

}

function getJwtUser(){
    try {

        if (! $user = \JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }

    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

        return response()->json(['token_expired'], $e->getStatusCode());

    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

        return response()->json(['token_invalid'], $e->getStatusCode());

    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

        return response()->json(['token_absent'], $e->getStatusCode());

    }

    return $user;
}

function setMetaData($data, array $metaDataValue){

    $return = null;

    if(empty($data)){ // no configuration value
        $return = json_encode($metaDataValue);
    } else {
        foreach($metaDataValue as $field => $val){ // update configuration value
            $data[$field] = $metaDataValue[$field];
        }
        $return = json_encode($data);
    }

    return $return;
}

function getMetaDataValue(array $meta, $searchField){

    if(!empty($meta)){ //
        foreach($meta as $f => $val){ //
            if ($f == $searchField) return $val;
        }

    }

    return;
}

function in_percentage($numerator, $denominator, $percentage = 100){
    if($numerator && $denominator){
        return round(($numerator / $denominator) * $percentage,2);
    }
    return 0;
}

function errorResponse($message){
    return response()->json([
        'hasError' => true,
        'message' => $message,
    ],422);
}

function to_db_date($string){
    $timestamp = strtotime($string);

    return date('Y-m-d', $timestamp);
}
function to_db_datetime($string){
    $timestamp = strtotime($string);

    return date('Y-m-d H:i:s', $timestamp);
}

function from_db_datetime($dateTime){
    $timestamp = strtotime($dateTime);

    return date('Y-m-d h:i:s A',$timestamp);
}

function strToDbTime($timeString)
{
    $timestamp = strtotime($timeString);

    return date('H:i:s',$timestamp);
}

function dbTimeToStr($time){
    $timestamp = strtotime($time);

    return date('h:i A',$timestamp);
}
