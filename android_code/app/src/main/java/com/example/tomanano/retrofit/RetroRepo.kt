package com.example.tomanano.retrofit

import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory

class RetroRepo {


    fun getRepo() : WebAPI {
        var retro =  Retrofit
            .Builder()
            .baseUrl("https://milkier-stator.000webhostapp.com/")
            .addConverterFactory(GsonConverterFactory.create())
            .build()

        return retro.create(WebAPI::class.java)
    }
}