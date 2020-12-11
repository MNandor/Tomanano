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

    @GET("join.php")
        fun joinRoom(@Query("user_email") email:String, @Query("room_id") id: Int, @Query("request_type") type:String="4"):
            Call<APIResponse>

    @GET("roomlist.php")
    fun getRooms(@Query("user_email") email:String, @Query("request_type") type:String="7")
        : Call<List<RoomData>>

    @GET("score.php")
    fun sendRes(@Query("user_email") email:String, @Query("room_id") id:Int,
                @Query("photos") photos:Int, @Query("persons") persons:Int,
                @Query("request_type") type:String="5")
    : Call<APIResponse>
}