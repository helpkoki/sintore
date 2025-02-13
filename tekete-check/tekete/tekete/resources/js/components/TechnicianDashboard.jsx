import React, { useState, useEffect } from 'react';
import { Card, CardHeader, CardTitle, CardContent } from './components/ui/card';
import { BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer, PieChart, Pie, Cell, Legend } from 'recharts';
import { Activity, Clock, AlertTriangle, CheckCircle, Ticket } from 'lucide-react';

const TechnicianDashboard = () => {
  const [data, setData] = useState(null);
  const [loading, setLoading] = useState(true);

  // Parse numeric strings to numbers and handle null/undefined values
  const parseNumericValue = (value, defaultValue = 0) => {
    if (value === null || value === undefined || value === '') return defaultValue;
    const parsed = parseFloat(value);
    return isNaN(parsed) ? defaultValue : parsed;
  };

  useEffect(() => {
    fetch('/dashboard')
      .then(res => {
        console.log('API response received:', res);
        if (!res.ok) {
          throw new Error('Network response was not ok');
        }
        return res.json();
      })
      .then(rawData => {
        console.log('Parsed API data:', rawData);
        // Transform the raw data to handle string numbers and ensure proper data structure
        const transformedData = {
          ticketsByStatus: rawData.ticketsByStatus?.map(item => ({
            ...item,
            count: parseNumericValue(item.count)
          })) || [],
          ticketsByPriority: rawData.ticketsByPriority?.map(item => ({
            ...item,
            count: parseNumericValue(item.count)
          })) || [],
          avgResolutionTime: {
            avg_hours: parseNumericValue(rawData.avgResolutionTime?.avg_hours)
          },
          satisfactionMetrics: {
            avg_rating: parseNumericValue(rawData.satisfactionMetrics?.avg_rating),
            total_rated: parseNumericValue(rawData.satisfactionMetrics?.total_rated)
          },
          responseTimeMetrics: {
            avg_response_minutes: parseNumericValue(rawData.responseTimeMetrics?.avg_response_minutes)
          }
        };

        setData(transformedData);
        setLoading(false);
      })
      .catch(error => {
        console.error('Error fetching dashboard data:', error);
        setLoading(false);
      });
  }, []);

  if (loading || !data) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <Activity className="w-8 h-8 animate-spin text-blue-500" />
      </div>
    );
  }

  const ticketsByStatus = data.ticketsByStatus || [];
  const ticketsByPriority = data.ticketsByPriority || [];
  const avgResolutionTime = data.avgResolutionTime?.avg_hours || 0;
  const satisfactionMetrics = data.satisfactionMetrics || { avg_rating: 0, total_rated: 0 };
  const responseTimeMetrics = data.responseTimeMetrics?.avg_response_minutes || 0;

  const STATUS_COLORS = {
    'Completed': '#10B981',
    'Escalate': '#EF4444',
    'In-Progress': '#F59E0B',
    'logged': '#3B82F6'
  };

  const PRIORITY_COLORS = {
    'Critical': '#DC2626',
    'High': '#EF4444',
    'Medium': '#F59E0B',
    'Low': '#10B981'
  };

  const formatMetric = (value, suffix = '') => {
    if (value === null || value === undefined || value === 0) return 'N/A';
    return `${value.toFixed(1)}${suffix}`;
  };

  const KPICard = ({ title, value, icon: Icon, description, color = 'text-gray-500' }) => (
    <Card className="bg-white">
      <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
        <CardTitle className="text-sm font-medium">
          {title}
        </CardTitle>
        <Icon className={`h-4 w-4 ${color}`} />
      </CardHeader>
      <CardContent>
        <div className="text-2xl font-bold">{value}</div>
        <p className="text-xs text-gray-500">{description}</p>
      </CardContent>
    </Card>
  );

  return (
    <div className="p-8 space-y-8">
      <h1 className="text-3xl font-bold mb-8">Technician Dashboard</h1>
      
      <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <KPICard
          title="Total Tickets"
          value={ticketsByStatus.reduce((acc, curr) => acc + curr.count, 0)}
          icon={Ticket}
          description="Total tickets assigned"
          color="text-blue-500"
        />
        <KPICard
          title="Resolution Time"
          value={formatMetric(avgResolutionTime, 'h')}
          icon={Clock}
          description="Average resolution time"
          color="text-yellow-500"
        />
        <KPICard
          title="Satisfaction Rate"
          value={formatMetric(satisfactionMetrics.avg_rating, '')}
          icon={CheckCircle}
          description={`Based on ${satisfactionMetrics.total_rated} ratings`}
          color="text-green-500"
        />
        <KPICard
          title="Response Time"
          value={formatMetric(responseTimeMetrics, 'm')}
          icon={Activity}
          description="Average first response time"
          color="text-blue-500"
        />
      </div>

      <div className="grid gap-4 md:grid-cols-2">
        <Card>
          <CardHeader>
            <CardTitle>Tickets by Status</CardTitle>
          </CardHeader>
          <CardContent className="h-80">
            <ResponsiveContainer width="100%" height="100%">
              <PieChart>
                <Pie
                  data={ticketsByStatus}
                  dataKey="count"
                  nameKey="status"
                  cx="50%"
                  cy="50%"
                  outerRadius={80}
                  label={({ name, percent }) => `${name} (${(percent * 100).toFixed(0)}%)`}
                >
                  {ticketsByStatus.map((entry) => (
                    <Cell key={entry.status} fill={STATUS_COLORS[entry.status]} />
                  ))}
                </Pie>
                <Tooltip />
                <Legend />
              </PieChart>
            </ResponsiveContainer>
          </CardContent>
        </Card>

        <Card>
          <CardHeader>
            <CardTitle>Tickets by Priority</CardTitle>
          </CardHeader>
          <CardContent className="h-80">
            <ResponsiveContainer width="100%" height="100%">
              <PieChart>
                <Pie
                  data={ticketsByPriority}
                  dataKey="count"
                  nameKey="priority"
                  cx="50%"
                  cy="50%"
                  outerRadius={80}
                  label={({ name, percent }) => `${name} (${(percent * 100).toFixed(0)}%)`}
                >
                  {ticketsByPriority.map((entry) => (
                    <Cell key={entry.priority} fill={PRIORITY_COLORS[entry.priority]} />
                  ))}
                </Pie>
                <Tooltip />
                <Legend />
              </PieChart>
            </ResponsiveContainer>
          </CardContent>
        </Card>
      </div>
    </div>
  );
};

export default TechnicianDashboard;