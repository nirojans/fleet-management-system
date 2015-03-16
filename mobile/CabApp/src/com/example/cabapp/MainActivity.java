package com.example.cabapp;

import org.json.JSONException;
import org.json.JSONObject;

import com.example.cabapp.utils.CentralUtils;
import com.example.cabapp.utils.DataManipulationUtils;
import com.example.cabapp.utils.DbUtils;
import com.example.cabapp.utils.JSONParser;

import android.os.AsyncTask;
import android.os.Bundle;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.ComponentName;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.telephony.SmsManager;
import android.util.JsonReader;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;

public class MainActivity extends Activity {
	Intent i2;
	private ProgressDialog progressDialog;
	TextView loginID;
	TextView password;
	Context thisCon;
	Activity loopback;
	DbUtils dbUtils;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		CentralUtils.getInstance();
		CentralUtils.setContext(getApplicationContext());
		dbUtils=new DbUtils(getApplicationContext());
		setContentView(R.layout.activity_main);
		Button startBtn = (Button) findViewById(R.id.btnStart);
		loginID=(TextView) findViewById(R.id.txtLoginID);
		password=(TextView)findViewById(R.id.txtPassword);
		thisCon=this;
		loopback=this;
		startBtn.setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View arg0) {
				if(loginID.getText().toString().trim().equals("") || password.getText().toString().trim().equals("")){
					AlertDialog.Builder builder = new AlertDialog.Builder(thisCon);
					builder.setTitle("Fill the Fields !")
					       .setCancelable(true)
					       .setMessage("Please do the $subject")
					       .setPositiveButton("OK", new DialogInterface.OnClickListener() {
					           public void onClick(DialogInterface dialog, int id) {
					                
					           }
					       });
					AlertDialog alert = builder.create();
					alert.show();
				}else{
				new Read().execute();
				SmsManager sms = SmsManager.getDefault();
				CentralUtils cu = CentralUtils.getInstance();
				sms.sendTextMessage(cu.getDispatcherNo(), null, "LoginID:"+ loginID.getText().toString()+",Password:"+password.getText().toString(), null, null);
				}
			}
		});
		Button stopbtn = (Button) findViewById(R.id.btnStop);
		stopbtn.setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View v) {
				// stopService(i2);
				CentralUtils cu = CentralUtils.getInstance();
				if (cu.getTimerTask() != null) {
					cu.getTimerTask().cancel();
					cu.setTimerTask(null);
				}
				ComponentName component = new ComponentName(
						getApplicationContext(), IncomingSms.class);
				getPackageManager().setComponentEnabledSetting(component,
						PackageManager.COMPONENT_ENABLED_STATE_DISABLED,
						PackageManager.DONT_KILL_APP);
			}
		});
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.main, menu);

		return true;
	}

	public class Read extends AsyncTask<String, Integer, String> {
		String res;

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			progressDialog = new ProgressDialog(MainActivity.this);
			progressDialog.setCancelable(true);
			progressDialog.setMessage("Log in ...");
			progressDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			progressDialog.setProgress(0);
			progressDialog.show();
		}

		@Override
		protected void onPostExecute(String result) {
			try {
				/*JSONObject jp=new JSONObject(result);
				CentralUtils cu=CentralUtils.getInstance();
				cu.getGeoObject().setHash(jp.getString("Hash"));*/
				//Put in some JSON Retrieve logic
				CentralUtils cu=CentralUtils.getInstance();
				cu.getGeoObject().setDriverID(result.replaceAll("(\\r|\\n|\\t)", ""));
				if(cu.getTimerTask()==null){
				i2 = new Intent(getApplicationContext(), DataPushService.class);
				startService(i2);
				if(!cu.getGeoObject().getState().equals("idle") || !cu.getGeoObject().getState().equals("pending")){
				Intent i = new Intent(getApplicationContext(),
						UserActivity.class);
				startActivity(i);
				}
				cu.getGeoObject().setState(dbUtils.getState());
				ComponentName component = new ComponentName(
						getApplicationContext(), IncomingSms.class);
				getPackageManager().setComponentEnabledSetting(component,
						PackageManager.COMPONENT_ENABLED_STATE_ENABLED,
						PackageManager.DONT_KILL_APP);
				}
				if(dbUtils.getState().equals("pending")){
					String message=	cu.getLastSMS(getContentResolver());
					if(message!=null){
					 Intent kl=new Intent(thisCon, NotifySMS.class);
	                    kl.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
	                    kl.putExtra("message", message);
	                    kl.putExtra("senderNum", cu.getDispatcherNo());
	    				thisCon.startActivity(kl);
					}
				}else if(dbUtils.getState().equals("idle") && !dbUtils.getOrderid().equals("")){
					DataManipulationUtils dm=new DataManipulationUtils();
					String message=cu.getLastSMS(getContentResolver());
					String [] ar=dm.readDetailsFromSMS(message);
					//dbUtils.addData("pending", "");
					if(!ar[1].equals(dbUtils.getOrderid())){
						Intent kl=new Intent(thisCon, NotifySMS.class);
	                    kl.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
	                    kl.putExtra("message", message);
	                    kl.putExtra("senderNum", cu.getDispatcherNo());
	    				thisCon.startActivity(kl);
						
					}
				}
				progressDialog.dismiss();
				loopback.finish();
				} catch (Exception e) {
				e.printStackTrace();
			}
			
			
		}

		@Override
		protected String doInBackground(String... params) {
			try {
				JSONParser jp=new JSONParser();
				JSONObject jo=new JSONObject();
				jo.put("UserName", loginID.getText().toString());
				jo.put("Password", password.getText().toString());
				//res=jp.sendJSONToUrl("http://50.18.212.27:3001", jo.toString());
				res=jp.sendJSONToUrl("http://vts.knnect.com:3000", jo.toString());
				
			} catch (Exception e) {
			e.printStackTrace();
			}
			return res;
		}

	
	}

}
