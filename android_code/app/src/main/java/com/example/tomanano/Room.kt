package com.example.tomanano

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.widget.Toast
import com.example.tomanano.retrofit.RetroRepo
import kotlinx.android.synthetic.main.activity_main.*
import kotlinx.android.synthetic.main.activity_room.*

class Room : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_room)

        Thread(Runnable {
            var r = RetroRepo()
            var c = r.getRepo().getRooms(Login.myEmail!!)



            var k = c.execute()


            var rooms = k.body()!!

            if (rooms.size < 1)
                return@Runnable

            var room = rooms[0]

            runOnUiThread{
                addRoomName.text = room.roomName
                addRoomId.text = room.roomID
            }

            
        }).start()
    }
}