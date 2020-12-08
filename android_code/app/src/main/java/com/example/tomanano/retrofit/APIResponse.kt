package com.example.tomanano.retrofit

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName


data class APIResponse (

    @Expose
    @SerializedName("success")
    val responseCode: Int?
)