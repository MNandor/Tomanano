package com.example.tomanano

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.View
import android.widget.Button
import android.widget.Toast
import com.example.tomanano.retrofit.RetroRepo
import kotlinx.android.synthetic.main.activity_login.*
import kotlinx.android.synthetic.main.activity_main.*
import kotlinx.android.synthetic.main.activity_register.*
import kotlinx.android.synthetic.main.activity_room.*

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        buttonJoinRoom.setOnClickListener{
            Thread(Runnable {
                var r = RetroRepo()
                var c = r.getRepo().joinRoom(Login.myEmail!!, RoomIp.text.toString().toInt())

                var k = c.execute()


                var code = k.body()!!.responseCode



                if (code != 0) //if successful
                    runOnUiThread{Toast.makeText(this@MainActivity,
                            "JOINED ROOM", Toast.LENGTH_LONG).show()}


            }).start()
        }

        buttonCreateRoom.setOnClickListener{
            Thread(Runnable {
                var r = RetroRepo()
                var c = r.getRepo().makeRoom(Login.myEmail!!, CreateRoomName.text.toString(),
                        startTime.text.toString(), endTime.text.toString())

                var k = c.execute()



                var code = k.body()!!.responseCode



                if (code != 0) //if successful
                    runOnUiThread{Toast.makeText(this@MainActivity,
                            "Room: "+code.toString(), Toast.LENGTH_LONG).show()}


            }).start()
        }

        cameraButton.setOnClickListener {
            //@Endre do your thing here
        }

        buttonRooms.setOnClickListener {
            startActivity(Intent(this, Room::class.java))

        }

    }


}