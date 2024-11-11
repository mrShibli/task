import React, { useState, useEffect } from 'react';
import ApexCharts from 'react-apexcharts';
import { getLogData } from '../api/logApi';

const Dashboard = () => {
    const [period, setPeriod] = useState('week');
    const [logData, setLogData] = useState([]);

    useEffect(() => {
        fetchLogData(period);
    }, [period]);

    const fetchLogData = async (selectedPeriod) => {
        try {
            const data = await getLogData(selectedPeriod);
            setLogData(data);
        } catch (error) {
            console.error("Error fetching log data:", error);
        }
    };

    const chartOptions = {
        chart: { id: 'log-stats' },
        xaxis: { categories: logData.map(entry => entry.date) },
        colors: ['#00E396', '#FF4560', '#775DD0'],
        labels: { formatter: val => val.toLocaleString() }
    };

    const chartSeries = [
        { name: 'Success', data: logData.map(d => d.success_count) },
        { name: 'Fail', data: logData.map(d => d.fail_count) },
        { name: 'Total', data: logData.map(d => d.total_count) }
    ];

    return (
        <div>
            <h2>Log Dashboard</h2>
            <div className="period-selector">
                <button onClick={() => setPeriod('week')}>Week</button>
                <button onClick={() => setPeriod('month')}>Month</button>
                <button onClick={() => setPeriod('semester')}>Semester</button>
            </div>
            <ApexCharts options={chartOptions} series={chartSeries} type="line" />
        </div>
    );
};

export default Dashboard;
