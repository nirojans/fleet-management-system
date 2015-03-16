package com.example.cabapp;

import java.util.Timer;
import java.util.TimerTask;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.example.cabapp.models.GeoJson;
import com.example.cabapp.utils.CentralUtils;
import com.example.cabapp.utils.GPSTracker;
import com.example.cabapp.utils.JSONParser;

import android.app.IntentService;
import android.content.Intent;
import android.location.Location;
import android.os.AsyncTask;
import android.os.Handler;
import android.text.format.Time;
import android.util.Log;
import android.widget.Toast;

public class DataPushService extends IntentService {
	

	public DataPushService() {
		super("My service");
	}

	final Handler handler = new Handler();
	Timer timer2 = new Timer();
	TimerTask doAsynchronousTask2;

	
	@Override
	protected void onHandleIntent(Intent arg0) {
 
		doAsynchronousTask2 = new TimerTask() {
			@Override
			public void run() {
				handler.post(new Runnable() {
					public void run() {
						CentralUtils cu = CentralUtils.getInstance();
						Location location=cu.getLocation();
						GeoJson geoJson=cu.getGeoObject();
						long timeStamp=System.currentTimeMillis() / 1000L;
						/*geoJson.setLatitiude(geo.getLatitude());
						geoJson.setLongitude(gp.getLongitude());*/
						new Read().execute(geoJson.getLatitiude()+"",geoJson.getLongitude()+"",geoJson.getEstimatedTime(),geoJson.getState(),geoJson.getHash(),geoJson.getCurrentOrderID(),geoJson.getDriverID(),geoJson.getSpeed()+"",geoJson.getBearing()+"",timeStamp+"");
						Log.d("Aawa", geoJson.getLatitiude()+":"+geoJson.getLongitude()+":"+geoJson.getState()+":"+geoJson.getHash());
					}
				});
			}
		};
		CentralUtils cu = CentralUtils.getInstance();
		cu.setTimerTask(doAsynchronousTask2);
		timer2.schedule(cu.getTimerTask(), 0, 5000);

	}

	public class Read extends AsyncTask<String, Integer, String> {
		String jsonString;
		@Override
		protected void onPostExecute(String jstring) {
			Log.d("Sent", jstring);
			Toast.makeText(getApplicationContext(), jstring, Toast.LENGTH_SHORT).show();
			CentralUtils cu=CentralUtils.getInstance();
			if(cu.getGeoObject().getState().equals("idle")){
				cu.getGeoObject().setCurrentOrderID("");
			}
		}

		@Override
		protected String doInBackground(String... arg0) {
			/*CentralUtils cu = CentralUtils.getInstance();
			GPSTracker gp = new GPSTracker(getApplicationContext());
			*//*
			 * cu.getGeoObject().setLatitiude(location.getLatitude())
			 * ;
			 * cu.getGeoObject().setLongitude(location.getLongitude
			 * ()); 
			 */JSONObject jb = new JSONObject();
			try {
				jb.put("type", "Feature");
				jb.put("id", arg0[6]);
				
				JSONObject propertyJb=new JSONObject();
				propertyJb.put("speed",arg0[7]);
				propertyJb.put("heading",arg0[8]);
				propertyJb.put("orderID", arg0[5]);
				propertyJb.put("estimatedTime", arg0[2]);
				propertyJb.put("state",arg0[3]);
				propertyJb.put("timeStamp",arg0[9]);
				propertyJb.put("information",arg0[4]);
				jb.put("properties", propertyJb);
				JSONObject geometryJb=new JSONObject();
				geometryJb.put("type","Point");
//				JSONArray jar=new JSONArray();
//				JSONObject latLng=new JSONObject();
				JSONArray latLng = new JSONArray();
				latLng.put(arg0[1]);
				latLng.put(arg0[0]);
//				jar.put(latLng);
				geometryJb.put("coordinates",latLng);
				jb.put("geometry", geometryJb);
			} catch (JSONException e) {
				e.printStackTrace();
			}
			JSONParser jp = new JSONParser();
			/*jsonString=jp.sendJSONToUrl("http://50.18.212.27:3001",
					jb.toString());
		*/	jsonString=jp.sendJSONToUrl("http://wso2.knnect.com:9763/endpoints/GpsDataOverHttp/geoJson",
					jb.toString());
			//jsonString=jp.getJSONFromUrl("http://maps.googleapis.com/maps/api/directions/json");
			return jb.toString();
		}
	}

}
