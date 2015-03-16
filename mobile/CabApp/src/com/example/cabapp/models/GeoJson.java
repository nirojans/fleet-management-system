package com.example.cabapp.models;

import java.util.HashMap;

public class GeoJson {
	private String driverID;
	private String currentOrderID;
	private Double latitiude=0.0;
	private Double longitude=0.0;
	private String state="";
	private String estimatedTime;
	private String hash;
	private double speed;
	private double bearing;
	private String hashCode;
	
	public String getState() {
		return state;
	}
	public void setState(String state) {
		this.state = state;
	}
	private HashMap<String, String> properties;
	
	/**
	 * @return the latitiude
	 */
	public Double getLatitiude() {
		return latitiude;
	}
	/**
	 * @param latitiude the latitiude to set
	 */
	public void setLatitiude(Double latitiude) {
		this.latitiude = latitiude;
	}
	/**
	 * @return the longitude
	 */
	public Double getLongitude() {
		return longitude;
	}
	/**
	 * @param longitude the longitude to set
	 */
	public void setLongitude(Double longitude) {
		this.longitude = longitude;
	}
	/**
	 * @return the properties
	 */
	public HashMap<String, String> getProperties() {
		return properties;
	}
	/**
	 * @param properties the properties to set
	 */
	public void setProperties(HashMap<String, String> properties) {
		properties = new HashMap<String, String>();
		this.properties = properties;
	}
	public String getEstimatedTime() {
		return estimatedTime;
	}
	public void setEstimatedTime(String estimatedTime) {
		this.estimatedTime = estimatedTime;
	}
	public String getHash() {
		return hash;
	}
	public void setHash(String hash) {
		this.hash = hash;
	}
	public String getDriverID() {
		return driverID;
	}
	public void setDriverID(String driverID) {
		this.driverID = driverID;
	}
	public String getCurrentOrderID() {
		return currentOrderID;
	}
	public void setCurrentOrderID(String currentOrderID) {
		this.currentOrderID = currentOrderID;
	}
	public double getSpeed() {
		return speed;
	}
	public void setSpeed(double speed) {
		this.speed = speed;
	}
	public double getBearing() {
		return bearing;
	}
	public void setBearing(double bearing) {
		this.bearing = bearing;
	}
	public String getHashCode() {
		return hashCode;
	}
	public void setHashCode(String hashCode) {
		this.hashCode = hashCode;
	}
}
