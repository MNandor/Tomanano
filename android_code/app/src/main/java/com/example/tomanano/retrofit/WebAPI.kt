package com.example.tomanano.retrofit


import retrofit2.Call
import retrofit2.http.GET
import retrofit2.http.Path
import retrofit2.http.Query

public interface WebAPI {


    @GET("registration.php")
    fun register(@Query("user_name") name:String, @Query("user_email") email:String,
                 @Query("user_pw") pw:String, @Query("request_type") type:String="1"): Call<APIResponse>


    @GET("login.php")
    fun login(@Query("user_email") email:String,
                 @Query("user_pw") pw:String, @Query("request_type") type:String="2"): Call<APIResponse>

    @GET("room.php")
        fun makeRoom(@Query("user_email") email:String, @Query("room_name") roomname:String,
                 @Query("start_date") startDate:String,  @Query("end_date") endDate:String,
                     @Query("request_type") type:String="3"): Call<APIResponse>
}