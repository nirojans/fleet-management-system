package com.example.cabapp;

import com.example.cabapp.models.GeoJson;
import com.example.cabapp.utils.CentralUtils;
import com.example.cabapp.utils.DbUtils;


import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.telephony.SmsManager;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.EditText;

public class UserActivity extends Activity {
	Activity loopback;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		loopback=this;
		setContentView(R.layout.activity_user);
		final Button reachedHome = (Button) findViewById(R.id.reachedHome);
		final Button passengerOnBoard = (Button) findViewById(R.id.passengerOnBoard);
		final Button endJourney = (Button) findViewById(R.id.endJourney);
		final DbUtils db = new DbUtils(getApplicationContext());
		final EditText estimatedTime= (EditText) findViewById(R.id.estimatedTime);
		GeoJson json=CentralUtils.getInstance().getGeoObject();
		CentralUtils.getInstance().setUserActivity(loopback);
		if(json.getState().trim().equals("accepted")){
			passengerOnBoard.setVisibility(View.INVISIBLE);
			endJourney.setVisibility(View.INVISIBLE);
			estimatedTime.setVisibility(View.INVISIBLE);
			endJourney.setVisibility(View.INVISIBLE);
		}else if((json.getState().trim().equals("reachedhome"))){
			reachedHome.setVisibility(View.INVISIBLE);
			passengerOnBoard.setVisibility(View.VISIBLE);
			estimatedTime.setVisibility(View.INVISIBLE);
			endJourney.setVisibility(View.INVISIBLE);
		}else if((json.getState().trim().equals("passenger On Board"))){
			InputMethodManager inputManager = (InputMethodManager)
                    getSystemService(this.INPUT_METHOD_SERVICE); 

inputManager.hideSoftInputFromWindow(getCurrentFocus().getWindowToken(),
                       InputMethodManager.HIDE_NOT_ALWAYS);reachedHome.setVisibility(View.INVISIBLE);
			passengerOnBoard.setVisibility(View.INVISIBLE);
			endJourney.setVisibility(View.VISIBLE);
			estimatedTime.setVisibility(View.VISIBLE);
		}else{
			reachedHome.setVisibility(View.INVISIBLE);
			passengerOnBoard.setVisibility(View.INVISIBLE);
			endJourney.setVisibility(View.INVISIBLE);
			estimatedTime.setVisibility(View.INVISIBLE);
		}
		
		reachedHome.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {
				CentralUtils cu = CentralUtils.getInstance();
				cu.getGeoObject().setState("reachedhome");
				db.addData("reachedhome",cu.getGeoObject().getCurrentOrderID());
				reachedHome.setVisibility(View.INVISIBLE);
				passengerOnBoard.setVisibility(View.VISIBLE);
				estimatedTime.setVisibility(View.VISIBLE);
				SmsManager sms = SmsManager.getDefault();
				sms.sendTextMessage(cu.getDispatcherNo(), null, cu.getGeoObject().getHashCode()+" "+cu.getGeoObject().getState(), null, null);
				 	
			}
		});

		passengerOnBoard.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {
				CentralUtils cu = CentralUtils.getInstance();
				if(!estimatedTime.getText().toString().trim().equals("")){
					cu.getGeoObject().setEstimatedTime(estimatedTime.getText().toString());
				}else{
					cu.getGeoObject().setEstimatedTime("");
				}
				cu.getGeoObject().setState("passenger On Board");
				db.addData("passenger On Board",cu.getGeoObject().getCurrentOrderID());
				passengerOnBoard.setVisibility(View.INVISIBLE);
				estimatedTime.setVisibility(View.INVISIBLE);
				endJourney.setVisibility(View.VISIBLE);
				SmsManager sms = SmsManager.getDefault();
				sms.sendTextMessage(cu.getDispatcherNo(), null, cu.getGeoObject().getHashCode()+" "+cu.getGeoObject().getState(), null, null);

			}
		});

		endJourney.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {
				CentralUtils cu = CentralUtils.getInstance();
				cu.getGeoObject().setState("idle");
				endJourney.setVisibility(View.INVISIBLE);
				Log.d("aawa", "order id :"+cu.getGeoObject().getCurrentOrderID());
				db.addData("idle",cu.getGeoObject().getCurrentOrderID());
				cu.getGeoObject().setCurrentOrderID("");
				cu.getGeoObject().setEstimatedTime("");
				SmsManager sms = SmsManager.getDefault();
				sms.sendTextMessage(cu.getDispatcherNo(), null, cu.getGeoObject().getHashCode()+" "+cu.getGeoObject().getState(), null, null);
				loopback.finish();
			}
		});

	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.user, menu);
		return true;
	}
	
	@Override
	public void onBackPressed() {
		Intent i=new Intent(getApplicationContext(),MainActivity.class);
		startActivity(i);
		super.onBackPressed();
	}

}
