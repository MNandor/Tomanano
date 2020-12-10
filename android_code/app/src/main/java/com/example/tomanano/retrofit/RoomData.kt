package com.example.tomanano.retrofit

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName

data class RoomData (
        @Expose
        @SerializedName("room_id")
        var roomID: String?,

        @Expose
        @SerializedName("room_name")
        var roomName: String?,

        @Expose
        @SerializedName("start_date")
        var startDate: String?,

        @Expose
        @SerializedName("end_date")
        var endDate: String?
)